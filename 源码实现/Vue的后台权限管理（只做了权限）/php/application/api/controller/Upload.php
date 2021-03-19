<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/5
 * Time: 12:04
 */

namespace app\api\controller;
use app\common\service\FileUploadService;

class Upload extends Common
{
    /**
     * 文件上传
     * 一次只允许上传一个文件
     *
     * param file_type      [必填]    文件类型，目前 image
     *
     * param file               上传的文件
     *
     * 图片独有的参数
     * param image_deal_type    [选填]    文件处理类型 1.不处理(值为空) 2.裁剪图片(crop) 3.缩略图(thumb)
     * 生成图片裁剪图
     * param crop_width     []
     * param crop_height    []
     * param crop_x
     * param crop_y
     * 生成图片缩略图
     * param thumb_type     [选填]    裁剪类型
     *      缩略图等比例缩放(THUMB_SCALING)
     *      缩略图缩放后填充(THUMB_FILLED)
     *      缩略图居中裁剪(THUMB_CENTER)
     *      缩略图左上角裁剪(THUMB_NORTHWEST)
     *      缩略图右下角裁剪(THUMB_SOUTHEAST)
     *      缩略图固定尺寸缩放(THUMB_FIXED)
     * param thumb_width    [选填]    裁剪的宽度
     * param thumb_height   [选填]    裁剪的高度
     *
     */
    public function upload(){
        $params = array();
        $params = $this->buildParam($params);

        try{

            switch ($params['file_type']){
                case 'image':

                    $FileUploadService = new FileUploadService();
                    $url = $FileUploadService->uploadImage($params);

                    break;
                default:
                    // 未知类型
                    throw new \Exception('未知类型文件');
            }
            $data = array(
                'url'=>$url
            );
            return $this->returnSuccess($data);

        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }




    }
}