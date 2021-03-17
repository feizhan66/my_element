<?php
/**
 * 返回
 * @param $url
 * @return mixed|string
 */
function urlToFilePath($url)
{
    $url = trim($url);
    $search = dirname($_SERVER['SCRIPT_NAME']);
    $search = str_replace('/', DS, $search);
    $path = str_replace('/', DS, $url);
    $path = $search==DS ? $path : str_replace($search,'', $path);
    $path = trim($path,DS);
    $path = ROOT_PATH.$path;
    return $path;
}

/**
 * @param $url
 * @param string $prefix
 * @return mixed|string
 */
function urlToFileName($url, $prefix='')
{
    $fileName = str_replace('/temp/', '/cache/', $url);
    $fileName = dirname($fileName).'/'.$prefix.basename($fileName);
    return $fileName;
}

/**
 * 移动文件(图片)
 * @param  $originalFile  原始文件(图片)位置
 * @param  $targetFile    目标文件(图片)位置
 **/
function moveFile($originalFile, $targetFile)
{
    if (is_file($originalFile))
    {
        rename($originalFile, $targetFile);
    }
}

/**
 * 删除文件(图片)
 * @param  $targetFile    目标文件(图片)
 **/
function deleteFile($targetFile)
{
    if (is_file($targetFile))
    {
        unlink($targetFile);
    }
}

/**
 * 百度编辑器的图片上传问题
 * @param $newContent
 * @param string $oldContent
 */
function manageFileToOSSByUeditorContent($newContent, $oldContent='')
{
    /* PHP正则提取图片img标记中的任意属性 */
    $newContent = htmlspecialchars_decode($newContent);
    $oldContent = htmlspecialchars_decode($oldContent);
    // 取整个图片代码
    $imagePregMatch = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
    preg_match_all($imagePregMatch,$newContent,$newMatch);
    preg_match_all($imagePregMatch,$oldContent,$oldMatch);
    $newMatch = $newMatch[2];
    $oldMatch = $oldMatch[2];
    // 提出相同图片元素
    $sameMatch = array_unique(array_intersect($newMatch, $oldMatch));
    // 提取需要上传图片
    $uploadMatch = array_diff($newMatch, $sameMatch);
    // 提取需要删除图片
    $deleteMatch = array_diff($oldMatch, $sameMatch);

    foreach ($uploadMatch as $key=>$value)
    {
        if(strpos($value, 'http://') !== false || strpos($value, 'https://') !== false )
        {
            // 引用图片,不做处理
        }
        else
        {
            // 获取图片对应路径
            $filePath = urlToFilePath($value);
            // 备份数据到OSS服务器
            uploadFileToOSS($filePath, str_replace('/temp/', '/ueditor/' , $value));
            // 删除本地临时文件
            deleteFile($filePath);
        }

    }
    foreach ($deleteMatch as $key=>$value)
    {
        if(strpos($value, 'http://') !== false || strpos($value, 'https://') !== false )
        {
            // 引用图片,不做处理
        }
        else
        {
            // 清除OSS服务器上相关数据
            deleteFileFromOSS(str_replace('/temp/', '/ueditor/' , $value));
        }
    }
}

/**
 * 适配百度编辑器文本图片路径问题
 * @param $content
 * @param bool $flag
 *        备注：只有在编辑
 *        1、为true，表示输出，
 *        2、为false时，表示输入
 * @return mixed|string
 */
function fixContentImagesURL($content, $flag=true)
{
    if ($flag)
    {
        /* PHP正则提取图片img标记中的任意属性 */
        $content = htmlspecialchars_decode($content);
        // 取整个图片代码
        $imagePregMatch = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
        preg_match_all($imagePregMatch, $content, $imagesMatch);
        $imagesMatch = $imagesMatch[2];

        foreach ($imagesMatch as $key=>$value)
        {
            if(strpos($value, 'http://') !== false || strpos($value, 'https://') !== false )
            {
                // 引用图片,不做处理
            }
            else
            {
                // 相对路径图片
                $content = str_replace($value, config('oss_url').$value , $content);
            }
        }
        $content = str_replace('/temp/', '/ueditor/' , $content);
    }
    else
    {
        $content = htmlspecialchars_decode($content);
        $content = str_replace(config('oss_url'), '' , $content);
        $content = htmlspecialchars($content);
        $content = str_replace('/ueditor/', '/temp/' , $content);
    }
    return $content;
}
