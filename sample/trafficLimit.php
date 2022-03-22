<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$secretId = "SECRETID"; //替换为用户的 secretId，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
$secretKey = "SECRETKEY"; //替换为用户的 secretKey，请登录访问管理控制台进行查看和管理，https://console.cloud.tencent.com/cam/capi
$region = "ap-beijing"; //替换为用户的 region，已创建桶归属的region可以在控制台查看，https://console.cloud.tencent.com/cos5/bucket
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => $region,
        'schema' => 'https', //协议头部，默认为http
        'endpoint' => ".cos-internal." . $region . ".tencentcos.cn", // 默认为内网域名，使用公网域名请修改cos-internal为cos
        'credentials'=> array(
            'secretId'  => $secretId ,
            'secretKey' => $secretKey)));

$local_path = '/data/exampleobject';
try {
    //上传对象，单链接限速
    $result = $cosClient->putObject(array(
        'Bucket' => 'examplebucket-125000000', //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
        'Key' => 'exampleobject',
        'Body' => fopen($local_path, 'rb'),
        'TrafficLimit' => 8 * 1024 * 1024 // 限制为1MB/s
    ));
    // 请求成功
    print_r($result);

    //下载对象，单链接限速
    $result = $cosClient->getObject(array(
        'Bucket' => 'examplebucket-125000000', //存储桶名称，由BucketName-Appid 组成，可以在COS控制台查看 https://console.cloud.tencent.com/cos5/bucket
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
