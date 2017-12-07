<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'cos-autoloader.php');

$cosClient = new Qcloud\Cos\Client(array('region' => getenv('COS_REGION'),
    'credentials'=> array(
        'appId' => getenv('COS_APPID'),
        'secretId'    => getenv('COS_KEY'),
        'secretKey' => getenv('COS_SECRET'))));
#listBuckets
try {
    $result = $cosClient->listBuckets();
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#createBucket
try {
    $result = $cosClient->createBucket(array('Bucket' => 'testbucket'));
    print_r($result);
    } catch (\Exception $e) {
    echo "$e\n";
}

#uploadbigfile
try {
    $result = $cosClient->upload(
                 $bucket='testbucket',
                 $key = '111.txt',
                 $body = str_repeat('a', 5* 1024 * 1024));
    print_r($result);
    } catch (\Exception $e) {
    echo "$e\n";
}

#putObject
try {
    $result = $cosClient->putObject(array(
        'Bucket' => 'testbucket',
        'Key' => '11/../11111////11',
        'Body' => 'Hello World!'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

//#getObject
//try {
//    $result = $cosClient->getObject(array(
//        'Bucket' => 'lewzylu02',
//        'Key' => 'tox.ini',
//        ));
//    echo(typeof($result));
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#deleteObject
//try {
//    $result = $cosClient->deleteObject(array(
//        'Bucket' => 'lewzylu02',
//        'Key' => '111.txt'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#deleteObjects
//try {
//    $result = $cosClient->deleteObjects(array(
//        // Bucket is required
//        'Bucket' => 'string',
//        // Objects is required
//        'Objects' => array(
//            array(
//                // Key is required
//                'Key' => 'string',
//                'VersionId' => 'string',
//            ),
//            // ... repeated
//        ),
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#deleteBucket
//try {
//    $result = $cosClient->deleteBucket(array(
//        'Bucket' => 'testbucket'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#headObject
//try {
//    $result = $cosClient->headObject(array(
//        'Bucket' => 'testbucket',
//        'Key' => '11'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#listObjects
//try {
//    $result = $cosClient->headObject(array(
//        'Bucket' => 'testbucket',
//        'Key' => '11'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#listObjects
//try {
//    $result = $cosClient->listObjects(array(
//        'Bucket' => 'testbucket'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#putObjectUrl
//try {
//    $bucket =  'testbucket';
//    $key = 'hello.txt';
//    $region = 'cn-south';
//    $url = "/{$key}";
//    $request = $cosClient->get($url);
//    $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
//    echo ($signedUrl);
//
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#putBucketACL
//try {
//    $result = $cosClient->PutBucketAcl(array(
//        'Bucket' => 'testbucket',
//        'Grants' => array(
//            array(
//                'Grantee' => array(
//                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
//                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
//                    'Type' => 'CanonicalUser',
//                ),
//                'Permission' => 'FULL_CONTROL',
//            ),
//            // ... repeated
//        ),
//        'Owner' => array(
//            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
//            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
//        ),));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#getBucketACL
//try {
//    $result = $cosClient->GetBucketAcl(array(
//        'Bucket' => 'testbucket',));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#putObjectACL
//try {
//    $result = $cosClient->PutBucketAcl(array(
//        'Bucket' => 'testbucket',
//        'Grants' => array(
//            array(
//                'Grantee' => array(
//                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
//                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
//                    'Type' => 'CanonicalUser',
//                ),
//                'Permission' => 'FULL_CONTROL',
//            ),
//            // ... repeated
//        ),
//        'Owner' => array(
//            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
//            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
//        ),));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#getObjectACL
//try {
//    $result = $cosClient->getObjectAcl(array(
//        'Bucket' => 'testbucket',
//        'Key' => '11'));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#putBucketLifecycle
//try {
//    $result = $cosClient->putBucketLifecycle(array(
//    // Bucket is required
//    'Bucket' => 'lewzylu02',
//    // Rules is required
//    'Rules' => array(
//        array(
//            'Expiration' => array(
//                'Days' => 1,
//            ),
//            'ID' => 'id1',
//            'Filter' => array(
//                'Prefix' => 'documents/'
//            ),
//            // Status is required
//            'Status' => 'Enabled',
//            'Transition' => array(
//                'Days' => 100,
//                'StorageClass' => 'NEARLINE',
//            ),
//            // ... repeated
//        ),
//    )));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#getBucketLifecycle
//try {
//    $result = $cosClient->getBucketLifecycle(array(
//        // Bucket is required
//        'Bucket' =>'lewzylu02',
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//
//#deleteBucketLifecycle
//try {
//    $result = $cosClient->deleteBucketLifecycle(array(
//        // Bucket is required
//        'Bucket' =>'lewzylu02',
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#putBucketCors
//try {
//    $result = $cosClient->putBucketCors(array(
//        // Bucket is required
//        'Bucket' => 'lewzylu02',
//        // CORSRules is required
//        'CORSRules' => array(
//            array(
//                'ID' => '1234',
//                'AllowedHeaders' => array('*'),
//                // AllowedMethods is required
//                'AllowedMethods' => array('PUT'),
//                // AllowedOrigins is required
//                'AllowedOrigins' => array('http://www.qq.com', ),
////                'ExposeHeaders' => array('*', ),
////                'MaxAgeSeconds' => 1,
//            ),
//            // ... repeated
//        ),
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#getBucketCors
//try {
//    $result = $cosClient->getBucketCors(array(
//        // Bucket is required
//        'Bucket' => 'lewzylu02',
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#deleteBucketCors
//try {
//    $result = $cosClient->deleteBucketCors(array(
//        // Bucket is required
//        'Bucket' => 'lewzylu02',
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//#copyobject
//try {
//    $result = $cosClient->copyObject(array(
//        // Bucket is required
//        'Bucket' => 'lewzylu02',
//        // CopySource is required
//        'CopySource' => 'lewzylu03-1252448703.cos.ap-guangzhou.myqcloud.com/tox.ini',
//        // Key is required
//        'Key' => 'string',
//    ));
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
//Copy
//try {
//    $result = $cosClient->Copy($bucket = 'lewzylu02',
//        $key = 'cmake-3.8.2为.tar.gz',
//        $copysource = 'lewzylu-1252448703.cos.ap-guangzhou.myqcloud.com/cmake-3.8.2为.tar.gz');
//    print_r($result);
//} catch (\Exception $e) {
//    echo "$e\n";
//}
