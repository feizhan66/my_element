<?php

namespace app\manage\controller;

use app\manage\model\AuthRuleModel;

//use think\Db;
/**
 * @breif 用户权限(规则)控制器
 **/
class UserRuleController extends CommonController
{
	/**
     * @breif 用户权限(规则)列表
     **/
	public function ruleList()
	{
		if ( request()->isAjax() || request()->isPost() )
        {
        	return json(['status'=>0,'message'=>'非法操作']);
        }
        else
        {
	        $field = 'tid,name,title,sort,status';
            $filterMap = array();
            $filterMap['pid'] = 0;
            $order = 'sort asc';
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
	        $this->assign('rules', $rules);
	        return view();
        }
	}

	/**
     * @breif 添加用户权限(规则)
     **/
	public function ruleAdd()
	{
		if ( request()->isAjax() || request()->isPost() )
        {
            $data['title'] 	    = input('title');
            $data['name']  	    = input('name');
            $data['sort']  	    = input('sort');
            $data['menu']       = input('menu');
            $data['status']     = input('status');
            $data['condition']  = input('condition');
            $data['icon']       = input('icon');
            $data['pid']   	    = input('pid');

//            $ruleDB = Db::name('auth_rule');

            $name = AuthRuleModel::field('name')->where(['name' => input('name')])->find();
            if($name)
            {
                return json(['status'=>0,'message'=>'用户权限重复']);
            }
            $result = AuthRuleModel::create($data);
            if($result)
            {
                return json(['status'=>1,'message'=>'添加用户权限成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'添加用户权限失败']);
            }
        }
        else
        {
            $field = 'tid,title';
            $filterMap = array();
            $filterMap['pid'] = 0;
            $order = 'sort asc';
            $rules = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
            foreach ($rules as $key=>$value)
            {
                $filterMap['pid'] = $value['tid'];
                $rules[$key]['subs'] = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
            }
            $this->assign('rules', $rules);
            return view();
        }
	}

	/**
     * @breif 权限-列表-json输出
     **/
	public function ruleJson()
	{
		if ( request()->isAjax() || request()->isPost() )
        {
	        $result = AuthRuleModel::get(input('tid'));
	        $this->assign('result', $result);

	        $field = 'tid,title';
            $filterMap = array();
            $filterMap['pid'] = 0;
            $order = 'sort asc';
            $rules = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
            foreach ($rules as $key=>$value)
            {
                $filterMap['pid'] = $value['tid'];
                $rules[$key]['subs'] = AuthRuleModel::field($field)->where($filterMap)->order($order)->select();
            }
            $this->assign('rules', $rules);

	        return json($result);
        }
        else
        {
            return json(['status'=>0,'message'=>'非法操作']);
        }
	}

	/**
     * @breif 编辑用户权限(规则)
     **/
	public function ruleEdit()
	{
		if ( request()->isAjax() || request()->isPost() )
        {
        	if (input('?tid')===false) 
            {
            	return json(['status'=>0,'message'=>'参数出错']);
            }

            $data['tid']        = input('tid');
            $data['title']      = input('title');
            $data['name']       = input('name');
            $data['sort']       = input('sort');
            $data['menu']       = input('menu');
            $data['status']     = input('status');
            $data['condition']  = input('condition');
            $data['icon']       = input('icon');
            $data['pid']        = input('pid');

            $result = AuthRuleModel::update($data);
            if($result)
            {
                return json(['status'=>1,'message'=>'编辑用户权限节点成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'编辑用户权限节点失败']);
            }
        }
        else
        {
            return json(['status'=>0,'message'=>'非法操作']);
        }
	}

	/**
     * @breif 删除用户权限(规则)(批量删除)
     **/
	public function ruleDeletes()
	{
        if ( request()->isAjax() || request()->isPost() )
        {
            $tids = input('tid');
            if(empty($tids))
            {
                return json(['status'=>0,'message'=>'参数出错']);
            }
            else
            {
                if ($this->checkParam('tid')===false) 
                {
                    return json(['status'=>0,'message'=>'参数有误']);
                }

                $tids = input('tid/a');
                $filterMap = array('tid'=>array('in',$tids));

                $count = AuthRuleModel::where($filterMap)->count();
                if($count>0)
                {
                    return json(['status'=>0,'message'=>'删除的用户权限含有下级用户权限,请先删除下级用户权限!']);
                }
                else
                {
                    $result = AuthRuleModel::destroy($tids);
                    if($result)
                    {
                        return json(['status'=>1,'message'=>'删除用户权限成功']);
                    }
                    else
                    {
                        return json(['status'=>0,'message'=>'删除用户权限失败']);
                    }
                }
            }
        }
        else
        {
            return json(['status'=>0,'message'=>'非法操作']);
        }
	}
}

?>