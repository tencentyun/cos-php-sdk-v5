<?php
require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = "SECRETID"; //"云 API 密钥 SecretId";
$secretKey = "SECRETKEY"; //"云 API 密钥 SecretKey";
$region = "ap-beijing"; //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
try {
    // start --------------- 存储桶图片审核 ----------------- //
    $result = $cosClient->imageDetect(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'test01.png',
        'ci-process' => 'sensitive-content-recognition', // 固定参数
        'detect-type' => 'porn,ads',
//        'interval' => 5, // 审核gif时使用 截帧的间隔
//        'max-frames' => 5, // 针对 GIF 动图审核的最大截帧数量，需大于0。
//        'biz-type' => '', // 审核策略
    ));
    // 请求成功
    print_r($result);
    // end --------------- 存储桶图片审核 ----------------- //



    // end --------------- 图片链接审核 ----------------- //
    $imgUrl = 'https://test.jpg';
    $result = $cosClient->imageDetect(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'ci-process' => 'sensitive-content-recognition', // 固定参数
        'Key' => '/', // 链接图片资源路径写 / 即可
        'detect-type' => 'porn,ads',
        'detect-url' => $imgUrl,
//        'interval' => 5, // 审核gif时使用 截帧的间隔
//        'max-frames' => 5, // 针对 GIF 动图审核的最大截帧数量，需大于0。
//        'biz-type' => '', // 审核策略
    ));
    // 请求成功
    print_r($result);
    // end --------------- 图片链接审核 ----------------- //
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}
