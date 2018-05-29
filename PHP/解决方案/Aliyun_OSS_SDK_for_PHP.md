## OSS的SDK
composer require aliyuncs/oss-sdk-php

配置项
```angular2html
// 您从OSS获得的AccessKeyId
'oss_access_key_id'     => '',
// 您从OSS获得的AccessKeySecret
'oss_access_key_secret' => '', 
// 您选定的OSS数据中心访问域名
'oss_endpoint'          => 'oss-cn-shanghai.aliyuncs.com', 
// 您使用的存储空间名称
'oss_bucket'            => '', 
// 访问OSS的域名
'oss_host'              => '',
// 文件下载到本地的路径
'oss_download_dir'      => public_path('uploads').'/download/oss', 
```

插件封装
```angular2html

namespace App\Util;
use OSS\OssClient;
use OSS\Core\OssException;
use Illuminate\Support\Facades\DB;

class AliYunOssUtil
{
    /**
     * 上传文件到OSS
     * 上传OSS成功后会删除本地的文件缓存
     * @param string $fileRealPath 本地文件的缓存绝对路径
     * @param string $fileId 待覆盖的文件id
     * @return string 返回OSS上的相对路径
     */
    public static function ossUploadFile($fileRealPath,$fileOssId = null){
        $accessKeyId = config('ossconfig.oss_access_key_id');
        $accessKeySecret = config('ossconfig.oss_access_key_secret');
        $endpoint = config('ossconfig.oss_endpoint');
        $bucket = config('ossconfig.oss_bucket');

        DB::beginTransaction();
        try {

            // 判断文件是否存在
            if(!is_file($fileRealPath)){
                throw new \Exception('待上传的文件不存在');
            }
            // 获取文件的 信息+后缀
            $pathinfo = pathinfo($fileRealPath);
            $md5_file = md5_file($fileRealPath);
            $object = "BlueOcean/".date('Y/m')."/".md5(uniqid()).'.'.strtolower($pathinfo['extension']);

            $oss_file_date = array();
            $oss_file_date['bucket'] = $bucket;

            $oss_file_date['updated_at'] =date('Y-m-d H:i:s');
            $oss_file_date['file_size'] = filesize($fileRealPath);// 计算文件大小
            $oss_file_date['file_name'] = $pathinfo['basename'];
            $oss_file_date['file_suffix'] = strtolower($pathinfo['extension']);
            $oss_file_date['md5'] = $md5_file;
            $oss_file_date['file_path'] = $object;

            // 在OSS上面的相对路径
            if(empty($fileOssId)){

                $oss_file_date['status'] = "1"; // 1新增
                $oss_file_date['created_at'] = date('Y-m-d H:i:s');

                DB::table('oss_file')->insertGetId($oss_file_date);
            }else{
                // 根据TD获取相对路径
                $oldFilePath = DB::table('oss_file')->where('id',$fileOssId)->value('file_path');
                if(empty($oldFilePath)){
                    throw new \Exception('获取不到原路径');
                }

                $oss_file_date['status'] = "2"; // 2更新

                // 更新数据库
                DB::table('oss_file')->where('id', $fileOssId)->update($oss_file_date);
            }

            // OSS实例化
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            // 上传文件
            $ossClient->uploadFile($bucket, $object, $fileRealPath);

            // 如果更新：上传成功后删除源文件
            if(!empty($fileOssId)){
                // 删除OSS源文件
                $ossClient->deleteObject($bucket, $oldFilePath);
            }

            // 上传成功后删除本地文件
            unlink($fileRealPath);
            DB::commit();
            return $object;

        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 下载OSS文件到本地
     * @param string $objectName OSS对象名称
     * @param null $FileName 文件名称（注意带后缀）
     * @return string 返回的是服务器物理路径
     * @throws \Exception
     */
    public static function ossGetObjectToLocalFile($objectName,$FileName = null){
        $accessKeyId = config('ossconfig.oss_access_key_id');
        $accessKeySecret = config('ossconfig.oss_access_key_secret');
        $endpoint = config('ossconfig.oss_endpoint');
        $bucket = config('ossconfig.oss_bucket');

        $oss_download_dir = config('ossconfig.oss_download_dir');

        try{
            // 判断文件夹是否存在(识别中文)
            $oss_download_dir = iconv("UTF-8", "GBK", $oss_download_dir);
            if(!file_exists($oss_download_dir)){
                mkdir ($oss_download_dir,0777,true);
            }

            if(empty($FileName)){
                // 如果传入的路径为空的话
                // 获取文件后缀
                $arr = explode('.',$objectName);

                $localfile = $oss_download_dir.'/'.uniqid().'.'.end($arr);
            }else{
                $localfile = $oss_download_dir.'/'.uniqid().trim($FileName,'/');
            }

            // 初始化服务器对象
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            // 设置
            $options = array(
                OssClient::OSS_FILE_DOWNLOAD => $localfile,
            );
            $ossClient->getObject($bucket, $objectName, $options);

            // 返回的是服务器物理地址
            return $localfile;

        }catch (OssException $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 删除在OSS上面的文件同步删除数据库
     * 注意：如果OSS上面没有该文件也是返回True
     * @param $objectFile string 文件在OSS上面的路径（不要加域名）
     */
    public static function ossDeleteFile($fileOssId){
        $accessKeyId = config('ossconfig.oss_access_key_id');
        $accessKeySecret = config('ossconfig.oss_access_key_secret');
        $endpoint = config('ossconfig.oss_endpoint');
        $bucket = config('ossconfig.oss_bucket');

        DB::beginTransaction();
        try {

            $objectName = DB::table('oss_file')->where('id',$fileOssId)->value('file_path');
            if(!empty($objectName)){
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $ossClient->deleteObject($bucket, $objectName);
            }

            DB::table('oss_file')->where('id',$fileOssId)->delete();

            DB::commit();
            return true;
        } catch (OssException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

}

```

