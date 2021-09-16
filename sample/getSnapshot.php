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
$time = 3.14;
$local_path = "/data/exampleobject/test.jpg";
try {
    /*
     * 如果访问400，media bucket unbinded, bucket's host is unavailable
     * 请先在控制台开启媒体处理开关
     */
    $result = $cosClient->getSnapshot(
        array(
            'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
            'Key' =>'exampleobject', //桶中的媒体文件,如test.mp4
            'ci-process' => 'snapshot', //操作类型，固定使用 snapshot
            'Time' => $time, //截图的时间点，单位为秒
            'SaveAs' => $local_path, //本地保存路径
//          'Width' => 0,
//          'Height' => 0,
//          'Format' => 'jpg',
//          'Rotate' => 'auto',
//          'Mode' => 'exactframe',
        )
    );
    // 请求成功
    echo($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}