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
$local_path = "/data/exampleobject";
try {
    $result = $cosClient->appendObject(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'Position' => 0, //追加对象位置
        'Body' => fopen($local_path, 'rb'),//读取文件内容
    ));
    /*
    $result = $cosClient->appendObject(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'Position' => (integer)$result['Position'], //取出上一个追加文件的对象位置进行追加
        'Body' => "hello", //文件流
    ));
    */
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}

