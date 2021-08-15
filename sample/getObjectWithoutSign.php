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
    $bucket = 'examplebucket-125000000'; //存储桶，格式：BucketName-APPID
    $key = "exampleobject"; //对象在存储桶中的位置，即对象键
    $signedUrl = $cosClient -> getObjectUrlWithoutSign($bucket, $key);

    // 请求成功
    echo $signedUrl;
} catch (\Exception $e) {
    // 请求失败
    print_r($e);
}

