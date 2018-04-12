<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/5
 * Time: 11:58
 * 文件上传的服务 todo 待做
 */

namespace app\common\service;


class FileUploadService
{
    /**
     * 文件上传
     * 一次只允许上传一个！
     *
     * 待优化：
     * 1.判断是否图片类型
     * 2.判断图片类型能否裁剪
     *
     * // 图片处理
     * params.image_width
     * params.image_height
     * params.thumb_type
     *
     */
    public function uploadImage($params){

        $file = request()->file('file');

        if (!$file){
            throw new \Exception('请正确上传图片');
        }

        if ($file){
            // 临时文件目录
            $imageTempPath = ROOT_PATH.'public'.DS.'uploads'.DS.'temp'.DS.'image'.DS;

            $imageInfo = $file->move($imageTempPath);

            $imagePath = $imageTempPath . $imageInfo->getSaveName();

            // 图片的处理
            switch ($params['image_deal_type']){
                case 'crop':
                    // 裁剪

                    $image = \think\Image::open($imagePath);

                    // crop_width 和 crop_height 同时非0存在才有效
                    // crop_x 和 crop_y 的值默认0 这个坐标是从右上角开始算

                    if (empty($params['crop_width']) && $params['crop_height']){
                        throw new \Exception('宽和高同时非零存在才有效');
                    }
                    if (empty($params['crop_height']) && $params['crop_width']){
                        throw new \Exception('宽和高同时非零存在才有效');
                    }
                    $params['crop_x'] = empty($params['crop_x']) ? 0 : $params['crop_x'];
                    $params['crop_y'] = empty($params['crop_y']) ? 0 : $params['crop_y'];

                    $image->crop($params['crop_width'], $params['crop_height'],$params['crop_x'],$params['crop_y'])->save($imagePath);

                    break;

                case 'thumb':
                    // 缩略图

                    $image = \think\Image::open($imagePath);

                    if ($params['thumb_width'] > 0 && $params['thumb_height'] > 0){
                        if ($image->width() != $params['thumb_width'] || $image->height() != $params['thumb_height'])
                        {
                            if ($params['thumb_type']=='THUMB_SCALING')
                            {// 缩略图等比例缩放
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_SCALING)->save($imagePath);
                            }
                            else if ($params['thumb_type']=='THUMB_FILLED')
                            {// 缩略图缩放后填充
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_FILLED)->save($imagePath);
                            }
                            else if ($params['thumb_type']=='THUMB_CENTER')
                            {// 缩略图居中裁剪
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_CENTER)->save($imagePath);
                            }
                            else if ($params['thumb_type']=='THUMB_NORTHWEST')
                            {// 缩略图左上角裁剪
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_NORTHWEST)->save($imagePath);
                            }
                            else if ($params['thumb_type']=='THUMB_SOUTHEAST')
                            {// 缩略图右下角裁剪
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_SOUTHEAST)->save($imagePath);
                            }
                            else if ($params['thumb_type']=='THUMB_FIXED')
                            {// 缩略图固定尺寸缩放
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_FIXED)->save($imagePath);
                            }else{
                                $image->thumb($params['thumb_width'], $params['thumb_height'], \think\Image::THUMB_SCALING)->save($imagePath);
                            }
                        }
                    }



                    break;
                default:
                    // 默认不做任何处理
            }



            $file_url = request()->root(true).'/uploads/temp/image/'.$imageInfo->getSaveName();

            // 表达符过滤
            $file_url = str_replace(DS, '/', $file_url);


//            echo $file_url;
            return $file_url;

//            echo $info->getSaveName().'<br>';
//            echo $info->getExtension().'<br>';
//            echo $info->getFilename().'<br>';

            // 文件的后缀
//            $extension = $info->getExtension();
//            $file_path = '';

//            echo ROOT_PATH;exit();








//            // 路径处理
//            $search = dirname($_SERVER['SCRIPT_NAME']);
//
//
//
//            $search = str_replace('/', DS, $search);
//
//
//            $search = $search==DS ? DS.'uploads':$search.DS.'uploads';
//
//            dump($search);exit();
//
//            $fileUrl = strstr($fileUrl, $search );
//            // 兼容windows系统
//            $fileUrl = str_replace(DS, '/', $fileUrl);











            // 能裁剪的图片后缀
//            $imageExtension = array('png','jpg','jpeg');
//            if (in_array($extension,$imageExtension)){
//                if ($params['image_width'] > 0 && $params['image_height'] > 0){
//                    $this->thumbImage();
//                }
//            }



        }else{
            // 文件上传错误
            throw new \Exception($file->getError());
        }

    }


}