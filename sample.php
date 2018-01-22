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
    $result = $cosClient->createBucket(array('Bucket' => 'testbucket-1252448703'));
    print_r($result);
    } catch (\Exception $e) {
    echo "$e\n";
}


#uploadbigfile
try {
    $result = $cosClient->upload(
        $bucket='testbucket-1252448703',
        $key = '111.txt',
        $body = str_repeat('a', 5* 1024 * 1024),
        $options = array(
            "ACL"=>'private',
            'CacheControl' => 'private'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putObject
try {
    $result = $cosClient->putObject(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '11//32//43',
        'Body' => 'Hello World!'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketVersioning
try {
    $result = $cosClient->putBucketVersioning(
    array('Bucket' => 'lewzylu02',
    'Status' => 'Enabled')
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getObject
try {
    $result = $cosClient->getObject(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '11',
        'VersionId' =>'111'
        ));
} catch (\Exception $e) {
    echo "$e\n";
}

#getBucketLocation
try {
    $result = $cosClient->getBucketLocation(array(
    'Bucket' => 'lewzylu02',
    ));
} catch (\Exception $e) {
    echo "$e\n";
}
;

#deleteObject
try {
    $result = $cosClient->deleteObject(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '111.txt'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteObjects
try {
    $result = $cosClient->deleteObjects(array(
        // Bucket is required
        'Bucket' => 'string',
        // Objects is required
        'Objects' => array(
            array(
                // Key is required
                'Key' => 'string',
                'VersionId' => 'string',
            ),
            // ... repeated
        ),
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucket
try {
    $result = $cosClient->deleteBucket(array(
        'Bucket' => 'testbucket-1252448703'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#headObject
try {
    $result = $cosClient->headObject(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '11',
        'VersionId' =>'111'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#headBucket
try {
    $result = $cosClient->headBucket(array(
        'Bucket' => 'testbucket-1252448703'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#listObjects
try {
    $result = $cosClient->headObject(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '11'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#ListObjectVersions
try {
    $result = $cosClient->ListObjectVersions(
        array('Bucket' => 'lewzylu02',
            'Prefix'=>'test1G')
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#listObjects
try {
    $result = $cosClient->listObjects(array(
        'Bucket' => 'testbucket-1252448703'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#getBucketVersioning
try {
    $result = $cosClient->getBucketVersioning(
        array('Bucket' => 'lewzylu02',)
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getObjectUrl
try {
    $bucket =  'testbucket-1252448703';
    $key = 'hello.txt';
    $region = 'cn-south';
    $url = "/{$key}";
    $request = $cosClient->get($url);
    $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
    echo ($signedUrl);

} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketACL
try {
    $result = $cosClient->PutBucketAcl(array(
        'Bucket' => 'testbucket-1252448703',
        'Grants' => array(
            array(
                'Grantee' => array(
                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
                    'Type' => 'CanonicalUser',
                ),
                'Permission' => 'FULL_CONTROL',
            ),
            // ... repeated
        ),
        'Owner' => array(
            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
        ),));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getBucketACL
try {
    $result = $cosClient->GetBucketAcl(array(
        'Bucket' => 'testbucket-1252448703',));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putObjectACL
try {
    $result = $cosClient->PutBucketAcl(array(
        'Bucket' => 'testbucket-1252448703',
        'Grants' => array(
            array(
                'Grantee' => array(
                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
                    'Type' => 'CanonicalUser',
                ),
                'Permission' => 'FULL_CONTROL',
            ),
            // ... repeated
        ),
        'Owner' => array(
            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
        ),));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getObjectACL
try {
    $result = $cosClient->getObjectAcl(array(
        'Bucket' => 'testbucket-1252448703',
        'Key' => '11'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketLifecycle
try {
    $result = $cosClient->putBucketLifecycle(array(
    // Bucket is required
    'Bucket' => 'testbucket-1252448703',
    // Rules is required
    'Rules' => array(
        array(
            'Expiration' => array(
                'Days' => 1,
            ),
            'ID' => 'id1',
            'Filter' => array(
                'Prefix' => 'documents/'
            ),
            // Status is required
            'Status' => 'Enabled',
            'Transition' => array(
                'Days' => 100,
                'StorageClass' => 'NEARLINE',
            ),
            // ... repeated
        ),
    )));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getBucketLifecycle
try {
    $result = $cosClient->getBucketLifecycle(array(
        // Bucket is required
        'Bucket' =>'testbucket-1252448703',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucketLifecycle
try {
    $result = $cosClient->deleteBucketLifecycle(array(
        // Bucket is required
        'Bucket' =>'testbucket-1252448703',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketCors
try {
    $result = $cosClient->putBucketCors(array(
        // Bucket is required
        'Bucket' => 'testbucket-1252448703',
        // CORSRules is required
        'CORSRules' => array(
            array(
                'ID' => '1234',
                'AllowedHeaders' => array('*'),
                // AllowedMethods is required
                'AllowedMethods' => array('PUT'),
                // AllowedOrigins is required
                'AllowedOrigins' => array('http://www.qq.com', ),
            ),
            // ... repeated
        ),
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getBucketCors
try {
    $result = $cosClient->getBucketCors(array(
        // Bucket is required
        'Bucket' => 'testbucket-1252448703',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucketCors
try {
    $result = $cosClient->deleteBucketCors(array(
        // Bucket is required
        'Bucket' => 'testbucket-1252448703',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#copyobject
try {
    $result = $cosClient->copyObject(array(
        // Bucket is required
        'Bucket' => 'lewzylu01-1252448703',
        // CopySource is required
        'CopySource' => 'lewzylu02-1252448703.cos.ap-guangzhou.myqcloud.com/test1G?versionId=MTg0NDY3NDI1NTk0MzUwNDQ1OTg',
        // Key is required
        'Key' => 'string',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#Copy
try {
    $result = $cosClient->Copy($bucket = 'lewzylu01-1252448703',
        $key = 'string',
        $copysource = 'lewzylu02-1252448703.cos.ap-guangzhou.myqcloud.com/test1G',
        $options = array('VersionId'=>'MTg0NDY3NDI1NTk0MzUwNDQ1OTg'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
#restoreObject
try {
    $result = $cosClient->restoreObject(array(
        // Bucket is required
        'Bucket' => 'lewzylu02',
        // Objects is required
        'Key' => '11',
        'Days' => 7,
        'CASJobParameters' => array(
            'Tier' =>'Bulk'
        )
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

