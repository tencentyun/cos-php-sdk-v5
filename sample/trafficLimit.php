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
$local_path = '/data/exampleobject';

try {
    //上传对象，单链接限速
    $result = $cosClient->putObject(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'Body' => fopen($local_path, 'rb'),
        'TrafficLimit' => 8 * 1024 * 1024 // 限制为1MB/s
    ));
    // 请求成功
    print_r($result);

    //下载对象，单链接限速
    $result = $cosClient->getObject(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'SaveAs' => $local_path,
        'TrafficLimit' => 8 * 1024 * 1024 // 限制为1MB/s
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}