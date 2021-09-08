<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = "SECRETID"; //"云 API 密钥 SecretId";
$secretKey = "SECRETKEY"; //"云 API 密钥 SecretKey";
$region = "ap-beijing"; //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials' => array(
            'secretId' => $secretId,
            'secretKey' => $secretKey)));
try {
    //存储桶图片审核
    $result = $cosClient->getObjectSensitiveContentRecognition(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'DetectType' => 'porn,politics' //可选四种参数：porn,politics,terrorist,ads，可使用多种规则，注意规则间不要加空格
//      'Interval' => 5, // 审核gif时使用 截帧的间隔
//      'MaxFrames' => 5, // 针对 GIF 动图审核的最大截帧数量，需大于0。
//      'BizType' => '', // 审核策略
    ));
    // 请求成功
    print_r($result);


    //图片链接审核
    $imgUrl = 'https://test.jpg';
    $result = $cosClient->getObjectSensitiveContentRecognition(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => '/', // 链接图片资源路径写 / 即可
        'DetectType' => 'porn,ads',//可选四种参数：porn,politics,terrorist,ads，可使用多种规则，注意规则间不要加空格
        'DetectUrl' => $imgUrl,
//      'Interval' => 5, // 审核gif时使用 截帧的间隔
//      'MaxFrames' => 5, // 针对 GIF 动图审核的最大截帧数量，需大于0。
//      'BizType' => '', // 审核策略
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}

