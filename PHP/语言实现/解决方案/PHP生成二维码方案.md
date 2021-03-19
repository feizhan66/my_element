# PHP生成二维码方案

## 使用的是endroid插件

- 安装：composer require endroid/qrcode

### 使用:
1. 基础使用方法
```
use Endroid\QrCode\QrCode;

$qrCode = new QrCode('Life is too short to be generating QR codes');

header('Content-Type: '.$qrCode->getContentType());

echo $qrCode->writeString();

```

2. 高级使用方法
```


  QR Code 
 By endroid 
      
 This library helps you generate QR codes in an easy way and provides a Symfony bundle for rapid integration in your project. 
 Installation 
 Use Composer to install the library. 
 $ composer require endroid/qrcode
 
 Basic usage 
 use Endroid\QrCode\QrCode;

$qrCode = new QrCode('Life is too short to be generating QR codes');

header('Content-Type: '.$qrCode->getContentType());
echo $qrCode->writeString();
 
 Advanced usage 
 use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Symfony\Component\HttpFoundation\Response;

// Create a basic QR code
$qrCode = new QrCode('Life is too short to be generating QR codes');
$qrCode->setSize(300);

// Set advanced options
$qrCode
    ->setWriterByName('png')
    ->setMargin(10)
    ->setEncoding('UTF-8')
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
    ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
    ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
    ->setLabel('Scan the code', 16, __DIR__.'/../assets/noto_sans.otf', LabelAlignment::CENTER)
    ->setLogoPath(__DIR__.'/../assets/symfony.png')
    ->setLogoWidth(150)
    ->setValidateResult(false)
;

// Directly output the QR code
header('Content-Type: '.$qrCode->getContentType());
echo $qrCode->writeString();

// Save it to a file
$qrCode->writeFile(__DIR__.'/qrcode.png');

// Create a response object
$response = new Response($qrCode->writeString(), Response::HTTP_OK, ['Content-Type' => $qrCode->getContentType()]);

```

## 使用 phpqrcode (比较老，原始，新项目不推荐)

- 下载地址
```angular2html
http://phpqrcode.sourceforge.net/
```
- 使用方法的简单封装
```angular2html
public function create($data){
    require_once "phpqrcode/qrlib.php";
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'demo'.DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR;

    if (!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);
    }

    $filename = $PNG_TEMP_DIR.md5(uniqid()).'.png';
    //html PNG location prefix
    //$PNG_WEB_DIR = 'temp/';
    
    \QRCode::png($data, $filename, 'Q', 4, 2);

    // URL
    return basename($filename);
}
```
