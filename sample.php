<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'cos-autoloader.php');

$cosClient = new Qcloud\Cos\Client(array('region' => getenv('COS_REGION'),
    'credentials'=> array(
        'appId' => getenv('COS_APPID'),
        'secretId'    => getenv('COS_KEY'),
        'secretKey' => getenv('COS_SECRET'))));

$bucket = 'lewzylu02-1252448703';

#listBuckets
try {
    $result = $cosClient->listBuckets();
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#createBucket
try {
    $result = $cosClient->createBucket(array('Bucket' => $bucket));
    print_r($result);
    } catch (\Exception $e) {
    echo "$e\n";
}


#uploadbigfile
try {
    $result = $cosClient->upload(
        $bucket=$bucket,
        $key = '111.txt',
        $body = str_repeat('a', 5* 1024 * 1024));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putObject
try {
    $result = $cosClient->putObject(array(
        'Bucket' => $bucket,
        'Key' => '11//32//43',
        'Body' => 'Hello Wo rld!',
        'ServerSideEncryption' => 'AES256'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketVersioning
try {
    $result = $cosClient->putBucketVersioning(
    array('Bucket' => $bucket,
    'Status' => 'Enabled'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getObject
try {
    $result = $cosClient->getObject(array(
        'Bucket' => $bucket,
        'Key' => '11',
        'VersionId' =>'111'));
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
};

#deleteObject
try {
    $result = $cosClient->deleteObject(array(
        'Bucket' => $bucket,
        'Key' => '111.txt',
        'VersionId' => 'string'));
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
        'Bucket' => $bucket));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#headObject
try {
    $result = $cosClient->headObject(array(
        'Bucket' => $bucket,
        'Key' => '11',
        'VersionId' =>'111',
        'ServerSideEncryption' => 'AES256'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#headBucket
try {
    $result = $cosClient->headBucket(array(
        'Bucket' => $bucket));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#listObjects
try {
    $result = $cosClient->listObjects(array(
        'Bucket' => $bucket,
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
        'Bucket' => $bucket));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#getBucketVersioning
try {
    $result = $cosClient->getBucketVersioning(
        array('Bucket' => 'lewzylu02-1252448703'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#getObjectUrl
try {
    $bucket =  $bucket;
    $key = 'hello.txt';
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
        'Bucket' => $bucket,
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
        'Bucket' => $bucket,));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putObjectACL
try {
    $result = $cosClient->putObjectACL(array(
        'Bucket' => $bucket,
        'Key' => '111',
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
        'Bucket' => $bucket,));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketACL
try {
    $result = $cosClient->PutBucketAcl(array(
        'Bucket' => $bucket,
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
        'Bucket' => $bucket,
        'Key' => '11'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketLifecycle
try {
    $result = $cosClient->putBucketLifecycle(array(
        // Bucket is required
        'Bucket' => 'lewzylu06-1252448703',
        // Rules is required
        'Rules' => array(
            array(
                'Expiration' => array(
                    'Days' => 1000,
                ),
                'ID' => 'id1',
                'Filter' => array(
                    'Prefix' => 'documents/'
                ),
                // Status is required
                'Status' => 'Enabled',
                'Transitions' => array(
                    array(
                        'Days' => 200,
                        'StorageClass' => 'NEARLINE'),
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
        'Bucket' =>$bucket,
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucketLifecycle
try {
    $result = $cosClient->deleteBucketLifecycle(array(
        // Bucket is required
        'Bucket' =>$bucket,
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#putBucketCors
try {
    $result = $cosClient->putBucketCors(array(
        // Bucket is required
        'Bucket' => $bucket,
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
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucketCors
try {
    $result = $cosClient->deleteBucketCors(array(
        // Bucket is required
        'Bucket' => $bucket,
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#copyobject
try {
    $result = $cosClient->copyObject(array(
        // Bucket is required
        'Bucket' => $bucket,
        // CopySource is required
        'CopySource' => 'lewzylu02-1252448703.cos.ap-guangzhou.myqcloud.com/test1G?versionId=MTg0NDY3NDI1NTk0MzUwNDQ1OTg',
        // Key is required
        'Key' => 'string',
        'ServerSideEncryption' => 'AES256'
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#Copy
try {
    $result = $cosClient->Copy($bucket = $bucket,
        $key = 'string',
        $copysource = 'lewzylu02-1252448703.cos.ap-guangzhou.myqcloud.com/test1G',
        $options = array('VersionId'=>'MTg0NDY3NDI1NTk0MzUwNDQ1OTg',
            'ServerSideEncryption' => 'AES256'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
#restoreObject
try {
    $result = $cosClient->restoreObject(array(
        'Bucket' => $bucket,
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

# Abort all MultipartUploads
# 删除所有因上传失败而产生的分块
try {
    $result = $cosClient->ListMultipartUploads(
        array('Bucket' => $bucket,
            'Prefix' => ''));
    if (count($result['Uploads']) == 0) {
        print_r("There is no MultipartUploads");
    }
    else {
        foreach ($result['Uploads'] as $upload) {
            try {
                $rt = $cosClient->AbortMultipartUpload(
                    array('Bucket' => $bucket,
                        'Key' => $upload['Key'],
                        'UploadId' => $upload['UploadId']));
                print_r($rt);
            } catch (\Exception $e) {
                print_r($e);
            }
        }
    }
} catch (\Exception $e) {
    echo "$e\n";
}