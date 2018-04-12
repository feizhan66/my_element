<?php
/**
 * 上传图片到OSS
 * @param $originalFilePath  文件原路径
 * @param $targetFileName    文件目标名称
 * @return boolean
 */
function uploadFileToOSS($originalFilePath, $targetFileName)
{
    if (is_file($originalFilePath))
    {
        // TODO 可能服务器上出问题
        //$web_base_path = ROOT_PATH;
//        $base_path = str_replace('\\','/',$base_path);
        $web_base_path = $_SERVER['DOCUMENT_ROOT'].'/';
//        dump($base_path);
//        exit();

        $targetFilePath = $web_base_path.trim($targetFileName,'/');


//        dump($targetFilePath);exit();

        $dirname = dirname($targetFilePath);

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            return false;
        } else if (!is_writeable($dirname)) {
            return false;
        }

        //移动文件
        rename($originalFilePath, $targetFilePath);
    }
}

/**
 * 删除图片从OSS
 * @param $targetFileName
 * @return boolean
 */
function deleteFileFromOSS($targetFileName)
{
    if ($targetFileName)
    {
        $targetFilePath = ROOT_PATH.trim($targetFileName,'/');
        if (is_file($targetFilePath))
        {
            unlink($targetFilePath);
        }
    }
}

?>