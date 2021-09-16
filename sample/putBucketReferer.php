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
    $result = $cosClient->putBucketReferer(
        array(
            'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
            'Status' => 'Enabled', //是否开启防盗链，枚举值：Enabled、Disabled
            'RefererType' => 'White-List', //防盗链类型，枚举值：Black-List、White-List
            'DomainList' => array(
                'Domains' => array(
                     '*.qq.com',
                     '*.qcloud.com',
                )
            ), //生效域名列表
//            'EmptyReferConfiguration' => 'Allow',//是否允许空 Referer 访问，枚举值：Allow、Deny，默认值为 Deny
        )
    );
    // 请求成功
    echo($result);
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}