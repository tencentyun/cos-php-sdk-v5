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
    // start --------------- 使用模版 ----------------- //
    $result = $cosClient->createMediaConcatJobs(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Tag' => 'Concat',
        'QueueId' => 'asdadadfafsdkjhfjghdfjg',
        'CallBack' => 'https://example.com/callback',
        'Input' => array(
            'Object' => 'video01.mp4'
        ),
        'Operation' => array(
            'TemplateId' => 'asdfafiahfiushdfisdhfuis',
            'Output' => array(
                'Region' => $region,
                'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
                'Object' => 'concat-video02.mp4',
            ),
        ),
    ));
    // 请求成功
    print_r($result);
    // end --------------- 使用模版 ----------------- //

    // start --------------- 自定义参数 ----------------- //
    $result = $cosClient->createMediaConcatJobs(array(
        'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
        'Tag' => 'Concat',
        'QueueId' => 'asdadadfafsdkjhfjghdfjg',
        'CallBack' => 'https://example.com/callback',
        'Input' => array(
            'Object' => 'video01.mp4'
        ),
        'Operation' => array(
            'Output' => array(
                'Region' => $region,
                'Bucket' => 'examplebucket-125000000', //格式：BucketName-APPID
                'Object' => 'concat-video03.mp4',
            ),
            'ConcatTemplate' => array(
                'ConcatFragments' => array(
                    array(
                        'Url' => 'https://example.com/video01.mp4',
                        'Mode' => 'Start',
//                        'StartTime' => '0',
//                        'EndTime' => '7',
                    ),
                    array(
                        'Url' => 'https://example.com/video02.mp4',
                        'Mode' => 'Start',
//                        'StartTime' => '0',
//                        'EndTime' => '10',
                    ),
                    // ... repeated
                ),
                'Index' => 1,
                'Container' => array(
                    'Format' => 'mp4'
                ),
                'Audio' => array(
                    'Codec' => 'mp3',
                    'Samplerate' => '',
                    'Bitrate' => '',
                    'Channels' => '',
                ),
                'Video' => array(
                    'Codec' => 'H.264',
                    'Bitrate' => '1000',
                    'Width' => '1280',
                    'Height' => '',
                    'Fps' => '30',
                ),
            ),
        ),
    ));
    // 请求成功
    print_r($result);
    // end --------------- 自定义参数 ----------------- //
} catch (\Exception $e) {
    // 请求失败
    echo($e);
}

