<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/19
 * Time: 11:27
 */

namespace app\api\controller;
use think\Db;
use app\common\service\UserRuleService;


class UserRule extends Common
{
    /**
     * 规则列表
     */
    public function ruleList(){

        try{

            $UserRuleService = new UserRuleService();
            $rules = $UserRuleService->ruleList();

            return $this->returnSuccess($rules);

        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }

    }

    /**
     * 规则详情
     */
    public function ruleDetail(){
        $params = array(
            'rule_id'=>'rule_id'
        );
        $params = $this->buildParam($params);
        try{

            $rule = Db::name('auth_rule')
                ->where(['id'=>$params['rule_id']])
                ->field('')
                ->find();
            // 获取父节点的值，一直到根
            $array = $this->ruleParent($params['rule_id'],[]);
            // 倒序排列
            sort($array);
            $rule['parent_id'] = $array;
            if (empty($rule['parent_id'])){
                $rule['parent_id'] = [0];
            }
            // 调用权限列表
            $UserRuleService = new UserRuleService();
            $rules = $UserRuleService->ruleList();
            // 添加一个根权限项
            $firstRules = [
                'id'=>0,
                'value'=>0,
                'name'=>'',
                'label'=>'根权限项'
            ];
            array_unshift($rules,$firstRules);
            $rule['rules'] = $rules;

            return $this->returnSuccess($rule);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }
    /**
     * 遍历查父节点
     */
    private function ruleParent($rule_id,$list=[]){
        $parent_id = Db::name('auth_rule')
            ->where(['id'=>$rule_id])
            ->value('parent_id');

        if (!empty($parent_id)){
            $list[] = $parent_id;
            $list = $this->ruleParent($parent_id,$list);
        }
        return $list;
    }

    /**
     * 修改规则
     * 父权限不能修改为自己子权限的子权限
     */
    public function ruleEdit(){
        $params = array(
            'id'        => 'id/not_null',
            'name'      => 'name/not_null',
            'title'     => 'title/not_null',
            'condition' => 'condition',
            'status'    => 'status',
            'parent_id' => 'parent_id/a'
        );
        $params = $this->buildParam($params);
        try{

            // 父TID不允许为0不允许为自己
            $params['parent_id'] = end($params['parent_id']);
            if (empty($params['parent_id'])){
                $params['parent_id'] = 0;
            }else{
                if ($params['parent_id'] == $params['id']){
                    throw new \Exception('父权限不允许是自己');
                }
            }
            // ID为1的是根权限，不允许变
            if ($params['id'] == 1 && $params['parent_id'] != 0){
                throw new \Exception('这是根节点，不允许修改');
            }

            // 父权限不能修改为自己子权限的子权限
            $childRules = $this->getChildRuleLists($params['id']);
            if (in_array($params['parent_id'],$childRules)){
                throw new \Exception('不允许修改为自己的子权限');
            }

            Db::name('auth_rule')->update($params);

            return $this->returnSuccess($childRules);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }

    }

    /**
     * 添加规则
     */
    public function ruleAdd(){
        $params = array(
            'name'      => 'name/not_null',
            'title'     => 'title/not_null',
            'condition' => 'condition',
            'status'    => 'status',
            'parent_id' => 'parent_id/a'
        );
        $params = $this->buildParam($params);
        Db::startTrans();
        try{

            // 获取到根的parent_id
            $params['parent_id'] = end($params['parent_id']);

            $rule_id = Db::name('auth_rule')->insertGetId($params);
            // 如果rule_id是1的话就一定是顶级
            if ($rule_id == 1){
                Db::name('auth_rule')
                    ->update([
                        'id'=>$rule_id,
                        'parent_id'=>0,
                    ]);
            }

            Db::commit();
            return $this->returnSuccess($params);
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 单个规则删除
     * 删除一个的话会把他的子节点也一并删除了
     */
    public function ruleDeleteOne(){
        $params = array(
            'rule'=>'rule/not_null'
        );
        $params = $this->buildParam($params);

        Db::startTrans();
        try{

            if ($params['rule'] == 1){
                throw new \Exception('不允许删除根节点');
            }

            // 查询是否有子节点
            $list = $this->getChildRuleLists($params['rule'],[]);
            $list[] = $params['rule'];

            Db::name('auth_rule')
                ->whereIn('id',$list)
                ->delete();

            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 递归遍历找子节点
     * @param       $parent_id
     * @param array $list
     * @return array
     */
    private function getChildRuleLists($parent_id,$list=[]){
        $rules = Db::name('auth_rule')
            ->where(['parent_id'=>$parent_id])
            ->column('id');

        if (!empty($rules)){
            foreach ($rules as $rules_key=>$rules_value){
                $list = $this->getChildRuleLists($rules_value,$list);
            }
        }
        $list = array_merge($list,$rules);
        return $list;
    }

    /**
     * 权限组列表
     */
    public function roleList(){
        $params = array();
        $params = $this->buildParam($params);
        try{
            //
            $roleList = Db::name('auth_role')
                ->where([])
                ->field('')
                ->select();
            $status_data = array('0'=>'关闭','1'=>'开启');
            foreach ($roleList as $role_key=>$role_value){
                $roleList[$role_key]['status'] = $status_data[$role_value['status']];
            }

            $data = array(
                'items'=>$roleList,
                'count'=>1000
            );

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 权限组详情
     */
    public function roleDetail(){
    	$params = array(
    		'role_id'=>'role_id'
    	);
    	$params = $this->buildParam($params);
    	try{
    		// 权限组的资料
    		$role = Db::name('auth_role')
	    		->where(['id'=>$params['role_id']])
	    		->field('id as role_id,title,description,rules,status')
	    		->find();
    		if (empty($role)){
    		    $role = array(
    		        'role_id'=>'',
                    'title'=>'',
                    'description'=>'',
                    'rules'=>'',
                    'status'=>0
                );
            }
	    	$has_rules = explode(',', $role['rules']);
	    	unset($role['rules']);

    		// 全部的权限项
    		$UserRuleService = new UserRuleService();
            $rules = $UserRuleService->ruleList();
    		
    		$data = array(
    			'role'=>$role,
    			'has_rules'=>$has_rules,
    			'rules'=>$rules
    		);
    	
    		return $this->returnSuccess($data);
    	}catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }

    }

    /**
     * 更新权限组
     */
    public function roleUpdate(){
        $params = array(
            'role_id'=>'role_id/not_null',
            'form'=>'form',
            'rules'=>'rules'
        );
        $params= $this->buildParam($params);

        try{

            $roleData = json_decode($params['form'],true);
            $roleData['rules'] = implode(',',json_decode($params['rules'],true));
            $roleData['id'] = $roleData['role_id'];
            unset($roleData['role_id']);

            Db::name('auth_role')->update($roleData);

            return $this->returnSuccess();
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }

    }

    /**
     * 添加权限组
     */
    public function roleAdd(){
        $params = array(
            'form'=>'form/a',
            'rules'=>'rules/a'
        );
        $params = $this->buildParam($params);

        Db::startTrans();
        try{

            $data = $params['form'];
            // 数组去重
            $rules = array_unique($params['rules']);
            $data['rules'] = implode(',',$rules);
            unset($data['role_id']);

            Db::name('auth_role')->insertGetId($data);

            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 删除权限组
     */
    public function roleDelete(){
        $params = array(
            'roles'=>'roles/a'
        );
        $params = $this->buildParam($params);

        Db::startTrans();
        try{
            Db::name('auth_role')
                ->whereIn('id',$params['roles'])
                ->delete();
            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 用户列表
     * 包含了用户组
     */
    public function userList(){
        $params = array(
            'page'=>'page',
            'size'=>'size'
        );
        $params = $this->buildParam($params);
        try{

            $userList = Db::name('user')->alias('u')
                ->join('__USER_PROFILE__ up','u.id=up.user_id')
                ->where([])
                ->page($params['page'],$params['size'])
                ->field('u.id as user_id,u.account,u.mobile_phone,u.status,up.name as user_name,up.sex,up.avatar')
                ->select();

            foreach ($userList as $user_key=>$user_value){
                $roles = Db::name('auth_role_access')->alias('ara')
                    ->join('__AUTH_ROLE__ ar','ara.role_id=ar.id')
                    ->where([
                        'ara.user_id'=>$user_value['user_id']
                    ])
                    ->column('title');
                $userList[$user_key]['roles'] = implode(',',$roles);
                unset($roles);
            }

            $userCount = Db::name('user')
                ->where([])
                ->count();

            $data = [
                'count'=>$userCount,
                'items'=>$userList
            ];

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 用户权限组列表
     */
    public function userRoleList(){
        $params = array(
            'people_id'=>'people_id'
        );
        $params = $this->buildParam($params);
        try{
            //
            $roleList = Db::name('auth_role')
                ->where(['status'=>1])
                ->field('id,title')
                ->select();
            $peopleRoles = Db::name('auth_role_access')
                ->where(['user_id'=>$params['people_id']])
                ->column('role_id');

            $data = array(
                'roleList'=>$roleList,
                'peopleRoles'=>$peopleRoles
            );
            return $this->returnSuccess($data);
        }catch (\Exception $exception){

            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 修改用户权限
     */
    public function alertUserRole(){
        $params = array(
            'people_id'=>'people_id/not_null',
            'roles'=>'roles/a'
        );
        $params = $this->buildParam($params);

        Db::startTrans();
        try{

            // 查询已经拥有的
            Db::name('auth_role_access')
                ->where(['user_id'=>$params['people_id']])
                ->delete();

            $data = [];
            foreach ($params['roles'] as $roles_key=>$roles_value){
                $data[] = [
                    'user_id'=>$params['people_id'],
                    'role_id'=>$roles_value,
                    'create_time'=>time(),
                    'update_time'=>time()
                ];
            }
            Db::name('auth_role_access')->insertAll($data);
            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }

    }

}