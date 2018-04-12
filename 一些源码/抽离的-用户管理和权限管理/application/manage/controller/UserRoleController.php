<?php

namespace app\manage\controller;

use app\manage\model\AuthRoleModel;
use app\manage\model\AuthRuleModel;
use think\Db;

/**
 * @breif 用户角色控制器
 **/
class UserRoleController extends CommonController
{
	/**
     * @breif 用户角色列表
     **/
    public function roleList()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
        	// 显示字段
        	$field = 'tid,title,description,sort,status';
            // 筛选条件
            $filterMap = array();
            $search = input('search');
            if ($search)
            {// 模糊搜索
                $filterMap['title|description'] = ['like','%'.$search.'%'];
            }
            // 排序
            $order = input('sort').' '.input('order');
            // 分页
            $limit = input('offset').','.input('limit');

            $roles = AuthRoleModel::field($field)
                     ->where($filterMap)
                     ->order($order)
                     ->limit($limit)
                     ->select();
            foreach ($roles as $key => $value)
            {
                $roles[$key]['manage'] = '<a href="javascript:;" title="编辑角色" '
                						.'onClick="roleEdit('.$value['tid'].')" '
                						.'style="padding-left:5px;"><i class="glyphicon glyphicon-pencil system_icon_color"></i></a>';
                $roles[$key]['manage'].= '<a href="javascript:;" title="删除角色" '
                						.'onclick="roleDel(this,'.$value['tid'].')" '
                						.'style="padding-left:5px;"><i class="glyphicon glyphicon-trash system_icon_color"></i></a>';
            }
            $result['rows'] = $roles;
            $result['total'] = AuthRoleModel::where($filterMap)->count();
            return json($result);
        }
        else
        {
            return view();
        }
    }

    /**
     * @breif 添加用户角色
     **/
    public function roleAdd()
    {
    	if ( request()->isAjax() || request()->isPost() )
        {
            $data['title']      = input('title');
            $data['description']= input('description');
            $data['status']     = input('status');
            $data['sort']       = input('sort');
            $data['rules'] = input('post.rules/a');//校验？
            $data['rules']      = trim(implode(',', $data['rules']),',');
            if(empty($data['rules']))
            {
                return json(['status'=>0,'message'=>'用户权限不能为空']);
            }

            $result = AuthRoleModel::create($data);
            if($result)
            {
                return json(['status'=>1,'message'=>'添加用户角色成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'添加用户角色失败']);
            }
        }
        else
        {
            $field = 'tid,title';
            $order = 'sort asc';
            $filterMap = array();
            $filterMap['status']= 1;
            $filterMap['pid'] 	= 0;
            $rules = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
            foreach ($rules as $key=>$value)
            {
            	$filterMap['pid'] = $value['tid'];
                $rules[$key]['subs'] = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
                foreach ($rules[$key]['subs'] as $subKey=>$subValue)
                {
                	$filterMap['pid'] = $subValue['tid'];
                    $rules[$key]['subs'][$subKey]['subs'] = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
                }
            }
            $this->assign('rules',$rules);
            return view();
        }
    }

    /**
     * @breif 编辑用户角色
     **/
    public function roleEdit()
    {
    	if ( request()->isAjax() || request()->isPost() )
        {
            $data['tid'] 		= input('tid');
            $data['title']      = input('title');
            $data['description']= input('description');
            $data['status']     = input('status');
            $data['sort']       = input('sort');

            $data['rules'] 		= input('post.rules/a');
            $data['rules']		= trim(implode(',', $data['rules']),',');
            if(empty($data['rules']))
            {
                return json(['status'=>0,'message'=>'用户权限不能为空']);
            }

            $data['rules'] = explode(',',$data['rules']);

            //每获取一个权限，都要获取其列表上的上一级权限，直到根权限为止（为的就是拿到列表的权限）
//            dump($data['rules']);

            $rutes_array = array();
            foreach ($data['rules'] as $rules_key=>$rutes_value){
                //递归遍历权限
                $rutes_array = $this->selectPidRule($rutes_value,$rutes_array);


            }
            $rutes_unique = array_unique($rutes_array);

            $data['rules'] = implode(',',$rutes_unique);

            $result = AuthRoleModel::update($data);
            if($result)
            {
                return json(['status'=>1,'message'=>'编辑用户角色成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'编辑用户角色失败']);
            }
        }
        else
        {

            if ($this->checkParam('tid')===false) 
            {
                $this->error('参数有误');
            }
            //获取某一权限组的信息
            $result = AuthRoleModel::get(input('tid'));

            $rules_exit = explode(',',$result['rules']);

            //除去父tid，也就是所有的跟权限都被除去只保留基础
            $pid_array = array();
            foreach ($rules_exit as $rule_val=>$rule_value){
                $pid_array = $this->selectPidRuleOnly($rule_value,$pid_array);
            }
            //获取非父TID
            $diff_result=array_diff($rules_exit,$pid_array);

            $this->assign('rules_data',$diff_result);

            $this->assign('result',$result->getData());

            $field = 'tid,title';
            $order = 'sort asc';
            $filterMap = array();
            $filterMap['status']= 1;
            $filterMap['pid']   = 0;

            // 获取所有权限项的信息
            $rules = AuthRuleModel::field($field)
                ->where($filterMap)
                ->order($order)
                ->select();

            foreach ($rules as $key=>$value)
            {
                $filterMap['pid'] = $value['tid'];

                // 获取所有的权限项信息
                $rules[$key]['subs'] = AuthRuleModel::field($field)
                    ->where($filterMap)
                    ->order($order)
                    ->select();

                foreach ($rules[$key]['subs'] as $subKey=>$subValue)
                {
                    $filterMap['pid'] = $subValue['tid'];
                    // 获取所有的权限项信息
                    $rules[$key]['subs'][$subKey]['subs'] = AuthRuleModel::field($field)
                        ->where($filterMap)
                        ->order($order)
                        ->select();

                }
            }

            $this->assign('rules',$rules);

            return view();
        }
    }

    /**
     * 递归，只获取父权限
     */
    public function selectPidRuleOnly($selectTid,$tidArray = array()){
        $selectTid = (int)$selectTid;
        $pid = Db::name('auth_rule')
            ->where(['tid'=>$selectTid])
            ->value('pid');
        $tidArray[] = (int)$pid;
        if (!empty($pid) && $pid!=0){
            $tidArray = $this->selectPidRule($pid,$tidArray);
        }
        return $tidArray;
    }


    /**
     * 递归查询权限父权限
     * 作用是循环的获取父权限，直到获取到权限是根为止
     */
    public function selectPidRule($selectTid,$tidArray = array()){
        $selectTid = (int)$selectTid;
        $tidArray[] = (int)$selectTid;

        $pid = Db::name('auth_rule')
            ->where(['tid'=>$selectTid])
            ->value('pid');
        $tidArray[] = (int)$pid;
        if (!empty($pid) && $pid!=0){
            $tidArray = $this->selectPidRule($pid,$tidArray);
        }
        return $tidArray;
    }




    /**
     * @breif 编辑用户角色表格
     **/
    public function roleTableEdit()
    {
    	if ( request()->isAjax() || request()->isPost() )
        {
            if ($this->checkParam('tid')===false) 
            {
                return json(['status'=>0,'message'=>'参数有误']);
            }

            $data['tid']        = input('tid');
            $data['title']      = input('title');
            $data['description']= input('description');
            $data['sort']       = input('sort');

            $result = AuthRoleModel::update($data);
            if($result)
            {
                return json(['status'=>1,'message'=>'编辑用户角色成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'编辑用户角色失败']);
            }
        }
        else
        {
        	return json(['status'=>0,'message'=>'非法操作']);
        }
    }

    /**
     * @breif 删除用户角色(批量删除)
     **/
    public function roleDeletes()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            if ($this->checkParam('tid')===false) 
            {
                return json(['status'=>0,'message'=>'参数有误']);
            }

            $tids = input('tid/a');
            $result = AuthRoleModel::destroy($tids);
            if ($result) 
            {
                return json(['status'=>1,'message'=>'删除用户角色成功']);
            }
            else 
            {
                return json(['status'=>0,'message'=>'删除用户角色失败']);
            }
        }
        else
        {
            return json(['status'=>0,'message'=>'非法操作']);
        }
    }

    /**
     * @breif 更改用户角色状态
     **/
    public function roleStatus()
    {
        // 管理员-更改状态
        if ( request()->isAjax() || request()->isPost() )
        {
            if ($this->checkParam('tid,status')===false) 
            {
                return json(['status'=>0,'message'=>'参数有误']);
            }

            $tid = input('tid');
            $result = AuthRoleModel::update(['tid'=>$tid, 'status'=>input('status')]);
            if($result)
            {
                return json(['status'=>1,'message'=>'更改用户角色状态成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'更改用户角色状态失败']);
            }
        }
        else
        {
            return json(['status'=>0,'message'=>'操作出错']);
        }
    }
}

?>