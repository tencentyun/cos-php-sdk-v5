<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = getenv('SECRET_ID'); //"云 API 密钥 SecretId";
$secretKey = getenv("SECRET_KEY"); //"云 API 密钥 SecretKey";
$region = getenv("COS_REGION"); //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
$time = 3;
try {
    $signedUrl = $cosClient->getSnapshot(
        array(
            'Bucket' => getenv('COS_BUCKET'), //格式：BucketName-APPID
            'Key' =>'movie.mp4',
            'ci-process' => 'snapshot',
            'Time' =>$time,
            'SaveAs' => '/Users/tuuna/Desktop/15.jpg',
        )
    );
    // 请求成功
    echo($signedUrl);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}