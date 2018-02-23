## PHP生成二维码方案

1. 使用的是endroid插件

- 安装：composer require endroid/qrcode

## 使用
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


