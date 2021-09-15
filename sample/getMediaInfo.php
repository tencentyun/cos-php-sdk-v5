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
    $result = $cosClient->GetMediaInfo(
        array(
            'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
            'Key' =>'exampleobject', //桶中的媒体文件,如test.mp4
            'ci-process' => 'videoinfo' //操作类型，固定使用 videoinfo
        )
    );
    // 请求成功
    echo($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}