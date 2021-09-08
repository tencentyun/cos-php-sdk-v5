<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = getenv('SECRET_ID'); //"云 API 密钥 SecretId";
$secretKey = getenv('SECRET_KEY'); //"云 API 密钥 SecretKey";
$region = getenv('COS_REGION'); //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
$local_path = "/Users/tuuna/Desktop/123hello.txt";

$tagSet = http_build_query( array(
    urlencode("key1") => urlencode("value1"),
    urlencode("key2") => urlencode("value2")),
    '',
    '&'
);

try {
    //上传对象，单链接限速
    $result = $cosClient->putObject(array(
        'Bucket' => getenv('COS_BUCKET'), //格式：BucketName-APPID
        'Key' => 'test191.txt',
        'Body' => fopen($local_path, 'rb'),
        'TrafficLimit' => 8 * 1000 * 1000 // 限制为1MB/s
    ));
    // 请求成功
    print_r($result);

    //下载对象，单链接限速
    $result = $cosClient->getObject(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Key' => 'exampleobject',
        'SaveAs' => '/data/exampleobject',
        'TrafficLimit' => 8 * 1000 * 1000 // 限制为1MB/s
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}