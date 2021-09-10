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
    // start --------------- 文本内容审核 ----------------- //
    $content = '敏感词';
    $result = $cosClient->detectText(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Input' => array(
            'Content' => base64_encode($content) // 文本需base64_encode
        ),
        'Conf' => array(
            'DetectType' => 'Porn,Terrorism,Politics,Ads', //Porn,Terrorism,Politics,Ads,Illegal,Abuse类型
            'BizType' => '',
        ),
    ));
    // 请求成功
    print_r($result);
    // end --------------- 文本内容审核 ----------------- //

    // start --------------- 存储桶文本文件审核 ----------------- //
    $result = $cosClient->detectText(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Input' => array(
            'Object' => 'test01.txt'
        ),
        'Conf' => array(
            'DetectType' => 'Porn,Terrorism,Politics,Ads',
            'Callback' => 'https://example.callback.com/test/', // 回调URL
            'BizType' => '',
        ),
    ));
    // 请求成功
    print_r($result);
    // end --------------- 存储桶文本文件审核 ----------------- //
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}

