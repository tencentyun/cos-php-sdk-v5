<?php

namespace Qcloud\Cos\Tests;

use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\CosException;

class BucketTest extends \PHPUnit_Framework_TestCase
{
    private $cosClient;
    private $bucket;
    protected function setUp()
    {
        $this->bucket = getenv('COS_BUCKET');
        TestHelper::nuke($this->bucket);
        $this->cosClient = new Client(array('region' => getenv('COS_REGION'),
            'credentials' => array(
                'appId' => getenv('COS_APPID'),
                'secretId' => getenv('COS_KEY'),
                'secretKey' => getenv('COS_SECRET'))));
        sleep(3);
    }

    protected function tearDown()
    {
        TestHelper::nuke($this->bucket);
    }

    /**********************************
     * TestBucket
     **********************************/

    /*
     * put bucket,bucket已经存在
     * BucketAlreadyOwnedByYou
     * 409
     */
    public function testCreateExistingBucket()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'BucketAlreadyOwnedByYou' && $e->getStatusCode() === 409);
        }
    }

    /*
     * put bucket,bucket名称非法
     * InvalidBucketName
     * 400
     */
    public function testCreateInvalidBucket()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'qwe_213'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidBucketName' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put bucket，设置bucket公公权限为private
     * 200
     */
    public function testCreatePrivateBucket()
    {
        try {
            $this->cosClient->createBucket(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'private'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket，设置bucket公公权限为public-read
     * 200
     */
    public function testCreatePublicReadBucket()
    {
        try {
            $this->cosClient->createBucket(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'public-read'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket，公共权限非法
     * InvalidArgument
     * 400
     */
    public function testCreateInvalidACLBucket()
    {
        try {
            $this->cosClient->createBucket(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'public'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidArgument' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put bucket acl，设置bucket公共权限为private
     * 200
     */
    public function testPutBucketAclPrivate()
    {
        try {

            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'private'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket公共权限为public-read
     * 200
     */
    public function testPutBucketAclPublicRead()
    {
        try {

            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'public-read'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，公共权限非法
     * InvalidArgument
     * 400
     */
    public function testPutBucketAclInvalid()
    {
        try {
            $this->cosClient->createBucket(
                array(
                    'Bucket' => $this->bucket,
                    'ACL'=>'public'
                ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidArgument' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限为grant-read
     * 200
     */
    public function testPutBucketAclReadToUser()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantRead' => 'id="qcs::cam::uin/1030872851:uin/1030872851"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限为grant-write
     * 200
     */
    public function testPutBucketAclWriteToUser()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantWrite' => 'id="qcs::cam::uin/1030872851:uin/1030872851"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限为grant-full-control
     * 200
     */
    public function testPutBucketAclFullToUser()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::cam::uin/1030872851:uin/1030872851"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，同时授权给多个账户
     * 200
     */
    public function testPutBucketAclToUsers()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::cam::uin/2779643970:uin/327874225",id="qcs::cam::uin/1030872851:uin/1030872851",id="qcs::cam::uin/327874225:uin/327874225"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，授权给子账号
     * 200
     */
    public function testPutBucketAclToSubuser()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::cam::uin/2779643970:uin/327874225"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，同时指定read、write和fullcontrol
     * 200
     */
    public function testPutBucketAclReadWriteFull()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantRead' => 'id="qcs::cam::uin/123:uin/123"',
                'GrantWrite' => 'id="qcs::cam::uin/2779643970:uin/327874225"',
                'GrantFullControl' => 'id="qcs::cam::uin/2779643970:uin/327874225"',));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，grant值非法
     * InvalidArgument
     * 400
     */
    public function testPutBucketAclInvalidGrant()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::camuin/321023:uin/327874225"',));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidArgument' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，通过body方式授权
     * 200
     */
    public function testPutBucketAclByBody()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' => $this->bucket,
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
                    'DisplayName' => 'qcs::cam::uin/2779643970:uin/2779643970',
                    'ID' => 'qcs::cam::uin/2779643970:uin/2779643970',
                )));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，设置bucket账号权限，通过body方式授权给anyone
     * 200
     */
    public function testPutBucketAclByBodyToAnyone()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' => $this->bucket,
                'Grants' => array(
                    array(
                        'Grantee' => array(
                            'DisplayName' => 'qcs::cam::anyone:anyone',
                            'ID' => 'qcs::cam::anyone:anyone',
                            'Type' => 'CanonicalUser',
                        ),
                        'Permission' => 'FULL_CONTROL',
                    ),
                    // ... repeated
                ),
                'Owner' => array(
                    'DisplayName' => 'qcs::cam::uin/2779643970:uin/2779643970',
                    'ID' => 'qcs::cam::uin/2779643970:uin/2779643970',
                )));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket acl，bucket不存在
     * NoSuchBucket
     * 404
     */
    public function testPutBucketAclBucketNonexisted()
    {
        try {
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::cam::uin/321023:uin/327874225"',));
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);
        }
    }

    /*
     * put bucket acl，覆盖设置
     * x200
     */
    public function testPutBucketAclCover()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantFullControl' => 'id="qcs::cam::uin/2779643970:uin/327874225"',
                'GrantRead' => 'id="qcs::cam::uin/2779643970:uin/327874225"',
                'GrantWrite' => 'id="qcs::cam::uin/2779643970:uin/327874225"'));
            $this->cosClient->PutBucketAcl(array(
                'Bucket' =>  $this->bucket,
                'GrantWrite' => 'id="qcs::cam::uin/2779643970:uin/327874225"'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 正常head bucket
     * 200
     */
    public function testHeadBucket()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->HeadBucket(array(
                'Bucket' =>  $this->bucket));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * head bucket，bucket不存在
     * NoSuchBucket
     * 404
     */
    public function testHeadBucketNonexisted()
    {
        try {
            $this->cosClient->HeadBucket(array(
                'Bucket' =>  $this->bucket,));
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);
        }
    }

    /*
     * get bucket,bucket为空
     * 200
     */
    public function testGetBucketEmpty()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->ListObjects(array(
                'Bucket' =>  $this->bucket));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * get bucket，bucket不存在
     * NoSuchBucket
     * 404
     */
    public function testGetBucketNonexisted()
    {
        try {
            $this->cosClient->ListObjects(array(
                'Bucket' =>  $this->bucket,));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);
        }
    }


    /*
     * put bucket cors，cors规则包含多条
     * 200
     */
    public function testPutBucketCors()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->putBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,
                // CORSRules is required
                'CORSRules' => array(
                    array(
                        'ID' => '1234',
                        'AllowedHeaders' => array('*',),
                        // AllowedMethods is required
                        'AllowedMethods' => array('PUT',),
                        // AllowedOrigins is required
                        'AllowedOrigins' => array('*',),
                        'ExposeHeaders' => array('*',),
                        'MaxAgeSeconds' => 1,
                    ),
                    array(
                        'ID' => '12345',
                        'AllowedHeaders' => array('*',),
                        // AllowedMethods is required
                        'AllowedMethods' => array('PUT',),
                        // AllowedOrigins is required
                        'AllowedOrigins' => array('*',),
                        'ExposeHeaders' => array('*',),
                        'MaxAgeSeconds' => 1,
                    ),
                    // ... repeated
                ),
            ));
            $this->cosClient->getBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }


    /*
     * 正常get bucket cors
     * 200
     */
    public function testGetBucketCors()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->putBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,
                // CORSRules is required
                'CORSRules' => array(
                    array(
                        'ID' => '1234',
                        'AllowedHeaders' => array('*',),
                        // AllowedMethods is required
                        'AllowedMethods' => array('PUT',),
                        // AllowedOrigins is required
                        'AllowedOrigins' => array('*',),
                        'ExposeHeaders' => array('*',),
                        'MaxAgeSeconds' => 1,
                    ),
                    array(
                        'ID' => '12345',
                        'AllowedHeaders' => array('*',),
                        // AllowedMethods is required
                        'AllowedMethods' => array('PUT',),
                        // AllowedOrigins is required
                        'AllowedOrigins' => array('*',),
                        'ExposeHeaders' => array('*',),
                        'MaxAgeSeconds' => 1,
                    ),
                    // ... repeated
                ),
            ));
            $this->cosClient->getBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * bucket未设置cors规则，发送get bucket cors
     * NoSuchCORSConfiguration
     * 404
     */
    public function testGetBucketCorsNull()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->getBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,));
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'NoSuchCORSConfiguration' && $e->getStatusCode() === 404);
        }
    }

    /*
     * bucket未设置cors规则，发送get bucket cors
     * NoSuchCORSConfiguration
     * 404
     */
    public function testGetBucketCorsNonExisted()
    {
        try {
            $this->cosClient->getBucketCors(array(
                // Bucket is required
                'Bucket' => $this->bucket,));
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);
        }
    }

    /*
     * 正常get bucket lifecycle
     * 200
     */
    public function testGetBucketLifecycle()
    {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => $this->bucket,
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
                                'Days' => 100,
                                'StorageClass' => 'Standard_IA'),
                        ),
                        // ... repeated
                    ),
                )));
            $result = $this->cosClient->getBucketLifecycle(array(
                // Bucket is required
                'Bucket' => $this->bucket,
            ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 正常delete bucket lifecycle
     * 200
     */
    public function testDeleteBucketLifecycle()
    {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => $this->bucket,
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
                                'Days' => 100,
                                'StorageClass' => 'Standard_IA'),
                        ),
                        // ... repeated
                    ),
                )));
            $result = $this->cosClient->deleteBucketLifecycle(array(
                // Bucket is required
                'Bucket' => $this->bucket,
            ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket lifecycle，请求body中不指定filter
     * 200
     */
    public function testPutBucketLifecycleNonFilter()
    {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => $this->bucket,
                // Rules is required
                'Rules' => array(
                    array(
                        'Expiration' => array(
                            'Days' => 1000,
                        ),
                        'ID' => 'id1',
                        // Status is required
                        'Status' => 'Enabled',
                        'Transitions' => array(
                            array(
                                'Days' => 100,
                                'StorageClass' => 'Standard_IA'),
                        ),
                        // ... repeated
                    ),
                )));
        } catch (\Exception $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);

        }
    }

    /*
     * put bucket,bucket名称带有-
     * 200
     */
    public function testPutBucket2()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket.'-12345'));
            $this->cosClient->deleteBucket(array('Bucket' => $this->bucket.'-12345'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket,bucket名称带有两个-
     * 200
     */
    public function testPutBucket3()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket.'-12333-4445'));
            $this->cosClient->deleteBucket(array('Bucket' => $this->bucket.'-12333-4445'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put bucket，bucket名称以-开头
     * InvalidBucketName
     * 400
     */
    public function testPutBucket4()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => '-12333-4445'.$this->bucket));
            $this->cosClient->deleteBucket(array('Bucket' => '-12333-4445'.$this->bucket));
        } catch (\Exception $e) {
//                        echo($e->getExceptionCode());
//                        echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'InvalidBucketName' && $e->getStatusCode() === 400);
        }
    }

    /*
     * 正常get bucket location
     * 200
     */
        public function testGetBucketLocation()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->getBucketLocation(array('Bucket' => $this->bucket));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * bucket不存在，发送get bucket location请求
     * NoSuchBucket
     * 404
     */
    public function testGetBucketLocationNonExisted()
    {
        try {
            $this->cosClient->getBucketLocation(array('Bucket' => $this->bucket));
        } catch (\Exception $e) {
            //            echo($e->getExceptionCode());
            //            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket' && $e->getStatusCode() === 404);
        }
    }

    /**********************************
     * TestObject
     **********************************/

    /*
     * put object,请求头部携带服务端加密参数
     * 200
     */
    public function testPutObjectEncryption()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => '11//32//43',
                'Body' => 'Hello World!',
                'ServerSideEncryption' => 'AES256'));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * Copy大文件
     * 200
     */
    public function testCopyBigFile()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->Copy($bucket = $this->bucket,
                $key = 'test10G',
                $copysource = 'lewzylu01-1252448703.cos.ap-guangzhou.myqcloud.com/test10g');
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * Copy小文件
     * 200
     */
    public function testCopySmallFile()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->copyObject(array(
                'Bucket' => $this->bucket,
                'CopySource' => 'lewzylu01-1252448703.cos.ap-guangzhou.myqcloud.com/test10M',
                'Key' => 'test10M',
                'ServerSideEncryption' => 'AES256'
            ));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 上传文件Bucket不存在
     * NoSuchBucket
     * 404
     */
    public function testPutObjectIntoNonexistedBucket() {
        try {
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket, 'Key' => 'hello.txt', 'Body' => 'Hello World'));
        } catch (CosException $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket');
            $this->assertTrue($e->getStatusCode() === 404);
        }
    }


    /*
     * 上传小文件
     * 200
     */
    public function testUploadSmallObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '你好.txt', 'Hello World');
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 上传空文件
     * 200
     */
    public function testPutObjectEmpty() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '你好.txt', '123');
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 上传已存在的文件
     * 200
     */
    public function testPutObjectExisted() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '你好.txt', '1234124');
            $this->cosClient->upload($this->bucket, '你好.txt', '请二位qwe');
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put object，请求头部携带自定义头部x-cos-meta-
     * 200
     */
    public function testPutObjectMeta() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => '你好.txt',
                'Body' => '1234124',
                'Metadata' => array(
                     'lew' => str_repeat('a', 1 * 1024),
            )));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * put object，请求头部携带自定义头部x-cos-meta-
     * KeyTooLong
     * 400
     */
    public function testPutObjectMeta2K() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => '你好.txt',
                'Body' => '1234124',
                'Metadata' => array(
                    'lew' => str_repeat('a', 3 * 1024),
                )));
        } catch (\Exception $e) {
//            echo($e->getExceptionCode());
//            echo($e->getStatusCode());
            $this->assertTrue($e->getExceptionCode() === 'KeyTooLong' && $e->getStatusCode() === 400);
        }
    }

    /*
     * 上传复杂文件名的文件
     * 200
     */
    public function testUploadComplexObject() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '→↓←→↖↗↙↘! \"#$%&\'()*+,-./0123456789:;<=>@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~', 'Hello World');
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 上传大文件
     * 200
     */
    public function testUploadLargeObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, 'hello.txt', str_repeat('a', 9 * 1024 * 1024));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 下载文件
     * 200
     */
    public function testGetObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '你好.txt', 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => '你好.txt',));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 获取文件url
     * 200
     */
    public function testGetObjectUrl() {
        try{
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->getObjectUrl($this->bucket, 'hello.txt', '+10 minutes');
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

    /*
     * 设置objectacl
     * 200
     */
    public function testPutObjectACL() {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '11', 'hello.txt');
            $this->cosClient->PutObjectAcl(array(
                'Bucket' => $this->bucket,
                'Key' => '11',
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
                    'DisplayName' => 'qcs::cam::uin/2779643970:uin/2779643970',
                    'ID' => 'qcs::cam::uin/2779643970:uin/2779643970',
                )));
        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }

    }


    /*
     * 获取objectacl
     * 200
     */
    public function testGetObjectACL()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => $this->bucket));
            $this->cosClient->upload($this->bucket, '11', 'hello.txt');
            $this->cosClient->PutObjectAcl(array(
                'Bucket' => $this->bucket,
                'Key' => '11',
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
                    'DisplayName' => 'qcs::cam::uin/2779643970:uin/2779643970',
                    'ID' => 'qcs::cam::uin/2779643970:uin/2779643970',
                )));

        } catch (\Exception $e) {
            $this->assertTrue($e->getStatusCode() === 200);
        }
    }

}