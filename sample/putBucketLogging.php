<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = "COS_SECRETID"; //"云 API 密钥 SecretId";
$secretKey = "COS_SECRETKEY"; //"云 API 密钥 SecretKey";
$region = "ap-beijing"; //设置一个默认的存储桶地域
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
try {
    $result = $cosClient->putBucketLogging(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket'=>$bucket,
        'LoggingEnabled' => array(
            'TargetBucket' => 'lewzylucd-1251668577',
            'TargetPrefix' => '', 
        )   
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo "$e\n";
}

