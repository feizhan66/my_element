<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/22
 * Time: 15:09
 */

namespace app\api\controller;
use think\Db;

class Shop extends Common
{
    /**
     * 离我最近 + 地区选择
     */
    public function shopList(){
        $params = array(
            'page'=>'page',
            'size'=>'size'
        );
        $params = $this->buildParam($params);
        try{
            $list = Db::name('shop')
                ->where([])
                ->page($params['page'],$params['size'])
                ->field('')
                ->select();

            foreach ($list as $list_key=>$list_value){
                if (empty($list_value['images'])){
                    $list[$list_key]['images'] = [config('default_shop_image')];
                }else{
                    $images = explode(',',$list_value['images']);
                    foreach ($images as $images_key=>$images_value){
                        $images[$images_key] = config('oss_url').$images_value;
                    }
                    $list[$list_key]['images'] = $images;
                    unset($images);
                }
            }

            return $this->returnSuccess($list);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 查询条件
     */
    public function shopCondition(){
        $params = array();
        $params = $this->buildParam($params);
        try{
            $district_ids = Db::name('shop')
                ->where(['status'=>1])
                ->column('district_id');
            $district_ids = array_unique($district_ids);
            $region = Db::name('region')
                ->whereIn('id',$district_ids)
                ->field('id as region_id,name')
                ->select();
            $default = array(
                'region_id'=>'0',
                'name'=>'全部'
            );
            array_unshift($region,$default);

            // 总数
            $count = Db::name('shop')
                ->where(['status'=>1])
                ->count();

            $data = array(
                'region'=>$region,
                'count'=>$count
            );

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     *
     */
    public function shopCreate(){
        $params = array(
            'name'      => 'name/not_null',
            'telephone' => 'telephone/not_null',
            'qq'        => 'qq',
            'province_id'=>'province_id',
            'city_id'   => 'city_id',
            'district_id'=>'district_id',
            'location'  => 'location', // 详细地址
            'images'    => 'images', // 图片路径
            'detail'    => 'detail', // 商家介绍
            'longitude' => 'longitude', // 经度
            'latitude'  => 'latitude', // 纬度
            'status'    => 'status',
            'shop_url'  => 'shop_url'
        );
        $params = $this->buildParam($params);
        Db::startTrans();
        try{

            // 处理图片
            if (!empty($params['images']))
            { //
                $images = explode(',',$params['images']);

                foreach ($images as $image_key=>$image_value){
                    $host_long = strlen(request()->domain());
                    $fileUri = substr($image_value,$host_long,strlen($image_value));

                    $filePath = urlToFilePath($fileUri);

                    $fileURL = urlToFileName($fileUri, 'shop_banner_image_');

                    // 上传图片到OSS
                    uploadFileToOSS($filePath, $fileURL);

                    $image_data[] = $fileURL;
                }
                $params['images'] = implode(',',$image_data);
            }

            $params['status'] = $params['status'] == 1 ? 1 : 0;

            Db::name('shop')->insert($params);

            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     *
     */
    public function shopUpdate(){
        $params = array(
            'shop_id'   => 'shop_id/not_null',
            'name'      => 'name',
            'telephone' => 'telephone/not_null',
            'qq'        => 'qq',
            'province_id'=>'province_id/not_null',
            'city_id'   => 'city_id/not_null',
            'district_id'=>'district_id/not_null',
            'location'  => 'location', // 详细地址
            'detail'    => 'detail', // 商家介绍
            'longitude' => 'longitude', // 经度
            'latitude'  => 'latitude', // 纬度
            'delete_images'=>'delete_images',
            'add_images'=> 'add_images',
            'status'    => 'status',
            'shop_url'  => 'shop_url'
        );
        $params = $this->buildParam($params);
        Db::startTrans();
        try{

            $data['id'] = $params['shop_id'];
            if (isset($params['name']))         $data['name']       = $params['name'];
            if (isset($params['telephone']))    $data['telephone']  = $params['telephone'];
            if (isset($params['qq']))           $data['qq']         = $params['qq'];
            if (isset($params['province_id']))  $data['province_id'] = $params['province_id'];
            if (isset($params['city_id']))      $data['city_id']    = $params['city_id'];
            if (isset($params['district_id']))  $data['district_id'] = $params['district_id'];
            if (isset($params['location']))     $data['location']   = $params['location'];
            if (isset($params['detail']))       $data['detail']     = $params['detail'];
            if (isset($params['longitude']))    $data['longitude']  = $params['longitude'];
            if (isset($params['latitude']))     $data['latitude']   = $params['latitude'];
            if (isset($params['status']))       $data['status']     = $params['status'];
            if (isset($params['shop_url']))     $data['shop_url']   = $params['shop_url'];

            $old_images = Db::name('shop')
                ->where(['id'=>$params['shop_id']])
                ->value('images');

            $old_images = explode(',',$old_images);

            // 处理图片
            if (!empty($params['add_images']))
            { //
                $images = explode(',',$params['add_images']);

                foreach ($images as $image_key=>$image_value){
                    $host_long = strlen(request()->domain());
                    $fileUri = substr($image_value,$host_long,strlen($image_value));

                    $filePath = urlToFilePath($fileUri);

                    $fileURL = urlToFileName($fileUri, 'shop_banner_image_');

                    // 上传图片到OSS
                    uploadFileToOSS($filePath, $fileURL);

                    $image_data[] = $fileURL;
                }
                // 两数组合并
                $old_images = array_merge($image_data,$old_images);
            }

            if (!empty($params['delete_images'])){
                $oss_host_long = strlen(config('oss_url'));
                $delete_images = explode(',',$params['delete_images']);
                // 处理主机头
                foreach ($delete_images as $delete_key=>$delete_value){
                    $delete_images[$delete_key] = substr($delete_value,$oss_host_long,strlen($delete_value));
                }

                // 差值(去掉)
                $old_images = array_diff($old_images,$delete_images);
                // 删掉图片
                foreach ($delete_images as $delete_key=>$delete_value){
                    deleteFileFromOSS($delete_value);
                }
            }

            $data['images'] = implode(',',$old_images);

            Db::name('shop')->insert($data);

            Db::commit();
            return $this->returnSuccess();
        }catch (\Exception $exception){
            Db::rollback();
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     *
     */
    public function shopDetail(){
        $params = array(
            'shop_id'=>'shop_id/not_null'
        );
        $params = $this->buildParam($params);
        try{

            $data = Db::name('shop')
                ->where(['id'=>$params['shop_id']])
                ->field('id as shop_id,name as shop_name,telephone,qq,province_id,city_id,district_id,location,detail,longitude,latitude,images')
                ->find();

            // 获取省市区
            $data['province_name'] = Db::name('region')
                ->where(['id'=>$data['province_id']])
                ->value('name');
            $data['city_name'] = Db::name('region')
                ->where(['id'=>$data['city_id']])
                ->value('name');
            $data['district_name'] = Db::name('region')
                ->where(['id'=>$data['district_id']])
                ->value('name');
            // 处理图片
            if (!empty($data['images'])){
                $images = explode(',',$data['images']);
                foreach ($images as $image_key=>$image_value){
                    $images[$image_key] = config('oss_url').$image_value;
                }
                $data['images'] = $images;
            }else{
                $data['images'] = [config('default_shop_image')];
            }

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

}