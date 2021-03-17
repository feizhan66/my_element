<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/12/30
 * Time: 17:18
 */

namespace app\api\controller;


class Region extends Common
{
    /**
     * 行政区域查询
     *
     * 已配权限
     *
     * param  region_id    [可选]    区域索引（默认：1）
     * param  keywords      [可选]    行政区名称（备注：如果region_tid存在，此参数忽略）
     * param  sub_district  [可选]    设置显示下级行政区级数（行政区级别包括：国家、省/直辖市、市、区/县、乡镇/街道多级数据）
     *                               可选值：0、1、2、3等数字，并以此类推（默认0）
     *                               0：不返回下级行政区；
     *                               1：返回下一级行政区；
     *                               2：返回下两级行政区；
     *                               3：返回下三级行政区；
     * 返回参数，参考高德：http://lbs.amap.com/api/webservice/guide/api/district
     */
    public function district()
    {
        $params         = input('param.');
        $region_id     = $params['region_id'] ? $params['region_id'] : 1;
        $keywords       = $params['keywords'];
        $sub_district   = $params['sub_district'] ?$params['sub_district'] : 0;


        try{

            if ($region_id == 1){
                if ($keywords){
                    //搜索关键词
                    $searchKeyWords = $keywords;
                }
            }
            if ($searchKeyWords)
            {
                $where['name'] = $keywords;
            }
            else
            {
                $where['id'] = $region_id;
            }
            $data = db('region')->where($where)->field('id,name,parent_id')->select();

            if ($sub_district >= 1)
            {
                foreach ($data as $k1 => $v1)
                {
                    $data[$k1]['children'] = $this->districtSearch($v1['id']);
                    if ($sub_district >= 2)
                    {
                        foreach ($data[$k1]['children'] as $k2 => $v2)
                        {
                            $data[$k1]['children'][$k2]['children'] = $this->districtSearch($v2['id']);
                            if ($sub_district >= 3)
                            {
                                foreach ($data[$k1]['children'][$k2]['children'] as $k3 => $v3)
                                {
                                    $data[$k1]['children'][$k2]['children'][$k3]['children'] = $this->districtSearch($v3['id']);
                                    if ($sub_district >= 4)
                                    {
                                        foreach($data[$k1]['children'][$k2]['children'][$k3]['children'] as $k4=>$v4)
                                        {
                                            $data[$k1]['children'][$k2]['children'][$k3]['children'][$k4]['children'] = $this->districtSearch($v4['id']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }


    }

    //查询数据
    public function districtSearch($id){
        $children = db('region')
            ->where(['parent_id'=>$id])
            ->field('id,name,parent_id')
            ->select();
        return $children;
    }
}