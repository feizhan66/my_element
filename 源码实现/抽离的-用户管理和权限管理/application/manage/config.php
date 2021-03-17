<?php

return [
    'dispatch_success_tmpl'  => APP_PATH . 'manage' . DS . 'view' . DS . 'error' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => APP_PATH . 'manage' . DS . 'view' . DS . 'error' . DS . 'dispatch_jump.tpl',
    //本项目的配置
    "manage_res" => "__ROOT__/public/static/manage",             //后台css js 等文件路径

    //图片上传配置
    'images_upload'    => [
      // 允许上传的文件MiMe类型
      'mimes'    => [],
      // 上传的文件大小限制 (0-不做限制)
      'maxSize'  => 0,
      // 允许上传的文件后缀
      'exts'     => ['jpg','png','jpeg'],
      // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
      'subName'  => [],
      // 保存根路径
      'rootPath' => ROOT_PATH . 'uploads/temp/image/', //图片临时路径
      // 保存路径
      'savePath' => '',
      // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
      'saveName' => ['md5', ''],
      // 文件上传驱动e,
      'driver'   => 'Local',
    ],

    //视频上传配置
    'video_upload'    => [
      // 允许上传的文件MiMe类型
      'mimes'    => [],
      // 上传的文件大小限制 (0-不做限制)
      'maxSize'  => 0,
      // 允许上传的文件后缀
      'exts'     => ['mp4'],
      // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
      'subName'  => [],
      //保存根路径
      'rootPath' => ROOT_PATH . 'uploads/temp/video/', //视频临时路径
      // 保存路径
      'savePath' => '',
      // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
      'saveName' => ['md5', ''],
      // 文件上传驱动e,
      'driver'   => 'Local',
    ],

    //文件上传配置
    'file_upload'    => [
      // 允许上传的文件MiMe类型
      'mimes'    => [],
      // 上传的文件大小限制 (0-不做限制)
      'maxSize'  => 0,
      // 允许上传的文件后缀
      'exts'     => [],
      // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
      'subName'  => [],
      //保存根路径
      'rootPath' => ROOT_PATH . 'uploads/temp/file/', //图片临时路径
      // 保存路径
      'savePath' => '',
      // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
      'saveName' => ['md5', ''],
      // 文件上传驱动e,
      'driver'   => 'Local',
    ],
    
];

?>
