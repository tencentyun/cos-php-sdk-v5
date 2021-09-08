cos-php-sdk-v5 Upgrade Guide
====================
2.2.3 to 2.3.0
---------
- 新增图片审核，视频审核，音频审核，文本审核，文档审核接口
- 新增单链接限速demo
- 暴露getPresigned接口Headers和Params参数接口
- 补充textDetect UT
- 修复stream_for废弃问题
- 修复x-cos头检测逻辑问题
- 修复UT部分bug

2.2.2 to 2.2.3
- 在putObejct中新增x-cos-tagging头
- 修复`GetObjectWithoutSign`bug

2.2.1 to 2.2.2
----------
新增appendObject SDK，包括sample,service,test
增加无签名对象下载地址 SDK，包括sample,service,test
增加全球加速相关配置参数
将COS_SECRETID修改为SECRETID、COS_SECRETKEY修改为SECRETKEY，防止混淆
修复部分逻辑代码bug
修复部分拼写错误
- Add `AppendObject` interface
- Add `GetObjectWithoutSign` interface
- Add `allow_accelerate` param to client
- Change const name `COS_SECRETID->SECRETID` `COS_SECRETKEY->SECRETKEY`
- Fix `getPresigned` interface
- Fix typo

2.2.0 to 2.2.1
----------
- Add `PutObjectTagging` interface
- Add `GetObjectTagging` interface
- Add `DeleteObjectTagging` interface

2.1.6 to 2.2.0
----------
- `PutObject` interface supports ci image process
- `GetObject` interface supports ci image process
- Add `ImageInfo` interface, which is used for get image info
- Add `ImageExif` interface, which is used for get image exif
- Add `ImageAve` interface, which is used for get image ave
- Add `ImageProcess` interface, which is used for data processing on cloud
- Add `Qrcode` interface, which is used for qrcode recognition
- Add `QrcodeGenerate` interface, which is used for generate qrcode
- Add `DetectLabel` interface, which is used for detect image label
- Add `PutBucketImageStyle` interface, which is used for add bucket image style
- Add `GetBucketImageStyle` interface, which is used for get bucket image style
- Add `DeleteBucketImageStyle` interface, which is used for delete bucket image style
- Add `PutBucketGuetzli` interface, which is used for open bucket guetzli state
- Add `GetBucketGuetzli` interface, which is used for get bucket guetzli state
- Add `DeleteBucketGuetzli` interface, which is used for close bucket guetzli state

2.1.5 to 2.1.6
----------
- Add `allow_redirects` parameter
- Fix `selectObjectContent` interface

2.1.3 to 2.1.5
----------
- The `download` interface supports breakpoint
- Rename `getPresignetUrl` to `getPresignedUrl`

2.1.2 to 2.1.3
----------
- Add `download` interface, which is used for concurrent block download
- Add callback of `upload` and `download` progress
- Fix request retry

2.1.1 to 2.1.2
----------
- The interface supports custom parameters
- Fix `ListBucketInventoryConfigurations`

2.1.0 to 2.1.1
----------
- Fix bug of urlencode when calculating signature

2.0.9 to 2.1.0
----------
- `upload` support upload with multithread
- Add `retry` params for interface retry
- Support add customer header
- Signature will restrict part of the header and all parameters
- Fix `listBuckets` with `doamin`

2.0.8 to 2.0.9
----------
- Fix bug of `listObjectVersions`
- Update `getObject` with param of `saveas`

2.0.7 to 2.0.8
----------
- Fix presigned url when using tmpSecretId/tmpSecretKey/Token

2.0.6 to 2.0.7
----------
- Fix response of `ListParts`

2.0.5 to 2.0.6
----------
- Support Domain
- Add Select Object Content Interface
- Add Traffic Limit
- Fix bug of object endswith /

2.0.4 to 2.0.5
----------
- Fix bug when upload object with metadata

2.0.3 to 2.0.4
----------
- Fix bug when using ip-port

2.0.2 to 2.0.3
----------
- Fix path parse bug with /0/

2.0.1 to 2.0.2
----------
- Fix bug of `putObject` with `fopen`
- Add ut


2.0.0 to 2.0.1
----------
- Add interface of inventory/tagging/logging
- Fix bug of some interface with query string


1.3 to 2.0
----------
cos-php-sdk-v5 now uses [GuzzleHttp] for HTTP message.
Due to fact, it depending on PHP >= 5.6.

- Use the `Qcloud\Cos\Client\getPresignetUrl()` method instead of the `Qcloud\Cos\Command\createPresignedUrl()`

v2:
```php
$signedUrl = $cosClient->getPresignetUrl($method='putObject',
                                         $args=['Bucket'=>'examplebucket-1250000000', 'Key'=>'exampleobject', 'Body'=>''],
                                         $expires='+30 minutes');
```

v1:
```php
$command = $cosClient->getCommand('putObject', array(
    'Bucket' => "examplebucket-1250000000",
    'Key' => "exampleobject",
    'Body' => '', 
));
$signedUrl = $command->createPresignedUrl('+30 minutes');
```

- `$copSource` parameters of the `Qcloud\Cos\Client\Copy` interface are no longer compatible with older versions.

v2:

```php
$result = $cosClient->copy( 
    $bucket = '<srcBucket>', 
    $Key = '<srcKey>', 
    $copySorce = array(
        'Region' => '<sourceRegion>', 
        'Bucket' => '<sourceBucket>', 
        'Key' => '<sourceKey>', 
    )
);
```

v1:
```php
$result = $cosClient->Copy(
    $bucket = '<srcBucket>',
    $key = '<srcKey>', 
    $copysource = '<sourceBucket>.cos.<sourceRegion>.myqcloud.com/<sourceKey>'
);
```
- Now when uploading files with using `open()` to upload stream, if the local file does not exist, a 0 byte file will be uploaded without throwing an exception, only a warning.

