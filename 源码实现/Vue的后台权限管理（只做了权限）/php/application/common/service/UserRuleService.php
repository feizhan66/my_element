<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/20
 * Time: 16:27
 */

namespace app\common\service;
use think\Db;

class UserRuleService
{
    /**
     * 所有的权限列表
     */
    public function ruleList(){

        return $this->getChildRule(0);
    }

    /**
     * 遍历查新子权限
     */
    private function getChildRule($parent_id,$rule=[]){
        $rule = Db::name('auth_rule')
            ->where(['parent_id'=>$parent_id])
            ->order('sort asc')
            ->field('id,id as value,name,title as label,sort,status')
            ->select();

        if (!empty($rule)){
            foreach ($rule as $rule_key=>$rule_value){

                if ($rule_value['status'] == 1){
                    $rule[$rule_key]['status_value'] = '开启';
                }else{
                    $rule[$rule_key]['status_value'] = '关闭';
                }

                $childRule = $this->getChildRule($rule_value['id']);
                if (!empty($childRule)){
                    $rule[$rule_key]['children'] = $childRule;
                }
            }
        }
        return $rule;
    }
}