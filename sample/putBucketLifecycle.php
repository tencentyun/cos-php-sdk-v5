<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = "SECRETID"; //替换为用户的 secretId，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
$secretKey = "SECRETKEY"; //替换为用户的 secretKey，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
$region = "ap-beijing"; //替换为用户的 region，已创建桶归属的region可以在控制台查看，https://console.cloud.tencent.com/cos5/bucket
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));
try {
    $result = $cosClient->putBucketLifecycle(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Rules' => array(
            array(
                'Expiration' => array(
                    'Days' => integer,
                ),  
                'ID' => 'string',
                'Filter' => array(
                    'Prefix' => 'string'
                ),  
                'Status' => 'string',
                'Transitions' => array(
                    array(
                        'Days' => integer,
                        'StorageClass' => 'string'
                    ),  
                    // ... repeated
                ),  
            ),  
            // ... repeated
        )
    ));
    // 请求成功
    print_r($result);
} catch (\Exception $e) {
    // 请求失败
    echo "$e\n";
}

