<?php

namespace app\manage\controller;

/**
 * @breif 
 *	权限认证类
 * @description 
 *	功能特性：
 *		1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      	$auth=new UserAuth();  $auth->check('规则名称','用户id')
 * 		2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      	$auth=new UserAuth();  $auth->check('规则1,规则2','用户id','and') 
 *      	第三个参数为and时，表示用户需要同时具有规则1和规则2的权限。 
 *			当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 		3，一个用户可以属于多个用户角色(mcppg_auth_role_access 定义了用户所属用户角色)。
 *			我们需要设置每个用户角色拥有哪些规则(mcppg_auth_role 定义了用户角色权限)
 * 		4，支持规则表达式。
 *      	在mcppg_auth_rule 表中定义一条规则时，如果type为1， condition字段就可以定义规则表达式。 
 *			如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
 */
class UserAuth
{
	// 默认配置
    protected $_config = array(
        'auth_on'           => true,				// 认证开关
        'auth_type'         => 1,					// 认证方式，1为实时认证；2为登录认证。
        'auth_role'        	=> 'auth_role',        	// 用户角色数据表名
        'auth_role_access' 	=> 'auth_role_access', 	// 用户-用户角色关系表
        'auth_rule'         => 'auth_rule',         // 权限规则表
        'auth_user'         => 'users'             	// 用户信息表
    );

    public function __construct() 
    {
        if (config('auth_config')) 
        {
            // 可设置配置项 auth_config, 此配置项为数组。
            $this->_config = array_merge($this->_config, config('auth_config'));
        }
    }

    /**
      * 检查权限
      * @param 	name 		string|array 	需要验证的规则列表,支持逗号分隔的权限规则或索引数组
      * @param 	uid  		int           	认证用户的id
      * @param 	relation 	string			如果为'or'表示满足任一条规则即通过验证;如果为'and'则表示需满足所有规则才能通过验证
	  * @param	mode 		string			执行check的模式
      * @return 			boolean			通过验证返回true;失败返回false
     */
    public function check($name, $uid, $relation='or', $type=1, $mode='url') 
    {
    	// 判断是否开启验证
        if ($this->_config['auth_on'] === false)
        {
        	return true;
        }
           
        // 获取用户需要验证的所有有效规则列表
        $authList = $this->getAuthList($uid, $type); 

        if (is_string($name)) 
        {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) 
            {
                $name = explode(',', $name);
            } 
            else 
            {
                $name = array($name);
            }
        }

        // 保存验证通过的规则名
        $list = array(); 
        if ($mode=='url') 
        {
            $REQUEST = unserialize( strtolower(serialize($_REQUEST)) );
        }
        foreach ( $authList as $auth ) 
        {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ($mode=='url' && $query!=$auth ) 
            {
                parse_str($query,$param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST,$param);
                $auth = preg_replace('/\?.*$/U','',$auth);
                if ( in_array($auth,$name) && $intersect==$param ) {  //如果节点相符且url参数满足
                    $list[] = $auth ;
                }
            }else if (in_array($auth , $name)){
                $list[] = $auth ;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 获得权限列表
     * @param 	$uid 	integer 	用户id
     * @param  	$type 	integer
     * @return 	array
     */
    protected function getAuthList($uid, $type)
    {
    	// 保存用户验证通过的权限列表
        static $_authList = array();
        $t = implode(',',(array)$type);
        if (isset($_authList[$uid . $t]))
        {
            return $_authList[$uid.$t];
        }
        if( $this->_config['auth_type']==2 && isset($_SESSION['_auth_list_'.$uid.$t]))
        {
            return $_SESSION['_auth_list_'.$uid.$t];
        }

        // 读取用户所属用户角色
        $roles = $this->getRoles($uid);

        // 保存用户所属用户角色设置的所有权限规则id
        $ids = array();
        foreach ($roles as $r)
        {
            $ids = array_merge($ids, explode(',', trim($r['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids))
        {
            $_authList[$uid.$t] = array();
            return array();
        }

        $map=array(
            'tid'=>array('in',$ids),
            'type'=>$type,
            'status'=>1,
        );
        // 读取用户组所有权限规则
        $rules = \think\Db::name($this->_config['auth_rule'])->where($map)->field('condition,name')->select();

        // 循环规则，判断结果。
        $authList = array();
        foreach ($rules as $rule)
        {
            if (!empty($rule['condition']))
            { // 根据condition进行验证
                $user = $this->getUserInfo($uid);// 获取用户信息,一维数组

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition)
                {
                    $authList[] = strtolower($rule['name']);
                }
            } else
            {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$uid.$t] = $authList;
        if($this->_config['auth_type']==2){
            //规则列表结果保存到session
            $_SESSION['_auth_list_'.$uid.$t]=$authList;
        }
        return array_unique($authList);
    }

    /**
     * 根据用户id获取用户角色,返回值为数组
     * @param  uid int     用户tid
     * @return array       用户所属的用户角色 array(
     *     array('uid'=>'用户id','role_tid'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getRoles($uid)
    {
        static $roles = array();

        if (isset($roles[$uid])) {
            return $roles[$uid];
        }

        $user_roles = \think\Db::name($this->_config['auth_role_access'])
            ->alias('a')
            ->join($this->_config['auth_role'] . " r", "r.tid=a.role_tid")
            ->where("a.user_tid='$uid' and r.status='1'")
            ->field('user_tid,role_tid,title,rules')->select();

        $roles[$uid] = $user_roles ? $user_roles : array();

        return $roles[$uid];
    }

    /**
     * 获得用户资料,根据自己的情况读取数据库
     */
    protected function getUserInfo($uid) 
    {
        static $userinfo=array();
        if(!isset($userinfo[$uid]))
        {
            $userinfo[$uid]=\think\Db::name($this->_config['auth_user'])->where(array('uid'=>$uid))->find();
        }
        return $userinfo[$uid];
    }

}

?>