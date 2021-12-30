<?php

namespace Qcloud\Cos\Tests;

use Qcloud\Cos\Exception\ServiceResponseException;

class CosClientObjectTest extends TestCosClientBase {

    private $key;
    private $appendKey;
    private $aclKey;
    /**********************************
     * TestObject
     **********************************/

    /*
     * put object, 从本地上传文件
     * 200
     */
    public function testPutObjectLocalObject() {
        try {
            $local_test_key = Common::LOCAL_TEST_FILE;
            $body = Common::generateFile();
            $md5 = base64_encode(md5($body, true));
            $this->cosClient->putObject(['Bucket' => $this->bucket,
                'Key' => $this->key,
                'Body' => fopen($local_test_key, "rb")]);
            $rt = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$this->key]);
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * upload, 从本地上传
     * 200
     */
    public function testUploadLocalObject() {
        try {
            $local_test_key = Common::LOCAL_TEST_FILE;
            $body = Common::generateFile();
            $md5 = base64_encode(md5($body, true));
            $this->cosClient->upload($bucket=$this->bucket,
                $key=$this->key,
                $body=fopen($local_test_key, "rb"),
                $options=['PartSize'=>1024 * 1024 + 1]);
            $rt = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$key]);
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * put object,请求头部携带服务端加密参数
     * 200
     */
    public function testPutObjectEncryption()
    {
        try {
            $this->cosClient->putObject(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => '11//32//43',
                    'Body' => 'Hello World!',
                    'ServerSideEncryption' => 'AES256'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }


    /*
     * 上传小文件
     * 200
     */
    public function testUploadSmallObject() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 上传空文件
     * 200
     */
    public function testPutObjectEmpty() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, '');
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * 上传已存在的文件
     * 200
     */
    public function testPutObjectExisted() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, '1234124');
            Common::waitSync();
            $this->cosClient->upload($this->bucket, $this->key, '请二位qwe');
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * put object，请求头部携带自定义头部x-cos-meta-
     * 200
     */
    public function testPutObjectMeta() {
        try {
            $meta = array(
                'test' => str_repeat('a', 1 * 1024),
                'test-meta' => '中文qwe-23ds-ad-xcz.asd.*qweqw'
            );
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'Body' => '1234124',
                'Metadata' => $meta

            ));
            $rt = $this->cosClient->headObject(array('Bucket'=>$this->bucket, 'Key'=>$this->key));
            $this->assertEquals($rt['Metadata'], $meta);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * upload large object，请求头部携带自定义头部x-cos-meta-
     * 200
     */
    public function testUploadLargeObjectMeta() {
        try {
            $meta = array(
                'test' => str_repeat('a', 1 * 1024),
                'test-meta' => 'qwe-23ds-ad-xcz.asd.*qweqw'
            );
            $body = Common::generateRandomString(2*1024*1024+1023);
            $this->cosClient->upload($this->bucket, $this->key, $body, array('PartSize'=>1024 * 1024 + 1, 'Metadata'=>$meta));
            Common::waitSync();
            $rt = $this->cosClient->headObject(['Bucket'=>$this->bucket, 'Key'=>$this->key]);
            $this->assertEquals($rt['Metadata'], $meta);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * put object，请求头部携带自定义头部x-cos-meta-
     * KeyTooLong
     * 400
     */
    public function testPutObjectMeta2K() {
        try {
            $this->cosClient->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'Body' => '1234124',
                'Metadata' => array(
                    'lew' => str_repeat('a', 3 * 1024),
                )));
            $this->assertTrue(False);
        } catch (ServiceResponseException $e) {
            $this->assertEquals(
                [400, 'KeyTooLong'],
                [$e->getStatusCode(), $e->getExceptionCode()]
            );

        }
    }

    /*
     * 上传复杂文件名的文件
     * 200
     */
    public function testUploadComplexObject() {
        try {
            $key = '→↓←→↖↗↙↘! \"#$%&\'()*+,-./0123456789:;<=>@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
            $this->cosClient->upload($this->bucket, $key, 'Hello World');
            $this->cosClient->headObject(array(
                'Bucket' => $this->bucket,
                'Key' => $key
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * 上传大文件
     * 200
     */
    public function testUploadLargeObject() {
        try {
            $body = Common::generateRandomString(2*1024*1024+1023);
            $md5 = base64_encode(md5($body, true));
            $this->cosClient->upload($bucket=$this->bucket,
                $key=$this->key,
                $body=$body,
                $options=['PartSize'=>1024 * 1024 + 1]);
            $rt = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$key]);
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 断点重传
     * 200
     */
    public function testResumeUpload() {
        try {
            $body = Common::generateRandomString(3*1024*1024+1023);
            $partSize = 1024 * 1024 + 1;
            $md5 = base64_encode(md5($body, true));
            $rt = $this->cosClient->CreateMultipartUpload(['Bucket' => $this->bucket,
                'Key' => $this->key]);
            $uploadId = $rt['UploadId'];
            $this->cosClient->uploadPart(['Bucket' => $this->bucket,
                'Key' => $this->key,
                'Body' => substr($body, 0, $partSize),
                'UploadId' => $uploadId,
                'PartNumber' => 1]);
            $rt = $this->cosClient->ListParts(['Bucket' => $this->bucket,
                'Key' => $this->key,
                'UploadId' => $uploadId]);
            $this->assertEquals(1, count($rt['Parts']));
            $this->cosClient->resumeUpload($bucket=$this->bucket,
                $this->key,
                $body,
                $uploadId,
                array('PartSize'=>$partSize));
            $rt = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$this->key]);
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * 下载文件
     * 200
     */
    public function testGetObject() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * range下载大文件
     * 200
     */
    public function testDownloadLargeObject() {
        try {
            $local_path = "test_tmp_file";
            $body = Common::generateRandomString(2*1024*1024+1023);
            $md5 = base64_encode(md5($body, true));
            $this->cosClient->upload($this->bucket,
                $this->key,
                $body,
                array('PartSize'=>1024 * 1024 + 1));
            $this->cosClient->download($this->bucket,
                $this->key,
                $local_path,
                array('PartSize'=>1024 * 1024 + 1));
            $body = file_get_contents($local_path);
            $download_md5 = base64_encode(md5($body, true));
            $this->assertEquals($md5, $download_md5);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }
    /*
     * get object，object名称包含特殊字符
     * 200
     */
    public function testGetObjectSpecialName() {
        try {
            $this->cosClient->upload($this->bucket, '你好<>!@#^%^&*&(&^!@#@!.txt', 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => '你好<>!@#^%^&*&(&^!@#@!.txt',));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * get object，请求头部带if-match，参数值为true
     * 200
     */
    public function testGetObjectIfMatchTrue() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'IfMatch' => '"b10a8db164e0754105b7a99be72e3fe5"'));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }


    /*
     * get object，请求头部带if-match，参数值为false
     * PreconditionFailed
     * 412
     */
    public function testGetObjectIfMatchFalse() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'IfMatch' => '""'));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertEquals(
                [412, 'PreconditionFailed'],
                [$e->getStatusCode(), $e->getExceptionCode()]
            );

        }
    }

    /*
     * get object，请求头部带if-none-match，参数值为true
     * 200
     */
    public function testGetObjectIfNoneMatchTrue() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $rt = $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'IfNoneMatch' => '"b10a8db164e0754105b7a99be72e3fe5"'));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }


    /*
     * get object，请求头部带if-none-match，参数值为false
     * PreconditionFailed
     * 412
     */
    public function testGetObjectIfNoneMatchFalse() {
        try {
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->cosClient->getObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'IfNoneMatch' => '""'));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 获取文件url
     * 200
     */
    public function testGetObjectUrl() {
        try{
            $this->cosClient->getObjectUrl($this->bucket, $this->key, '+10 minutes');
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 获取文件基本url
     * 200
     */
    public function testGetObjectUrlWithoutSign() {
        try{
            $result = $this->cosClient->getObjectUrlWithoutSign($this->bucket, $this->key);
            $tmpUrl = 'https://' . $this->bucket . '.cos.' . Common::getRegion() . '.myqcloud.com/' . $this->key;
            $this->assertEquals($result, $tmpUrl);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 复制小文件
     * 200
     */
    public function testCopySmallObject() {
        try{
            $this->cosClient->upload($this->bucket, $this->key, 'Hello World');
            $this->cosClient->copy($bucket=$this->bucket,
                $test_key='hello.txt',
                $copySource = ['Bucket'=>$this->bucket,
                    'Region'=>Common::getRegion(),
                    'Key'=>$this->key]);
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * 复制大文件
     * 200
     */
    public function testCopyLargeObject() {
        try{
            $src_key = '你好.txt';
            $dst_key = 'hi.txt';
            $body = Common::generateRandomString(2*1024*1024+333);
            $md5 = base64_encode(md5($body, true));
            $this->cosClient->upload($bucket=$this->bucket,
                $key=$src_key,
                $body=$body,
                $options=['PartSize'=>1024 * 1024 + 1]);
            $this->cosClient->copy($bucket=$this->bucket,
                $key=$dst_key,
                $copySource = ['Bucket'=>$this->bucket,
                    'Region'=>Common::getRegion(),
                    'Key'=>$src_key],
                $options=['PartSize'=>1024 * 1024 + 1]);

            $rt = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$dst_key]);
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * 设置objectacl
     * 200
     */
    public function testPutObjectACL() {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'Grants' => array(
                        array(
                            'Grantee' => array(
                                'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'Type' => 'CanonicalUser',
                            ),
                            'Permission' => 'FULL_CONTROL',
                        ),
                        // ... repeated
                    ),
                    'Owner' => array(
                        'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                        'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                    )
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            
            $this->assertFalse(True);
        }
    }

    /*
     * 获取objectacl
     * 200
     */
    public function testGetObjectACL()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'Grants' => array(
                        array(
                            'Grantee' => array(
                                'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'Type' => 'CanonicalUser',
                            ),
                            'Permission' => 'FULL_CONTROL',
                        ),
                    ),
                    'Owner' => array(
                        'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                        'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                    )
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            
            $this->assertFalse(True);
        }
    }

    /*
        * put object acl，设置object公共权限为private
        * 200
        */
    public function testPutObjectAclPrivate()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'ACL'=>'private'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，设置object公共权限为public-read
     * 200
     */
    public function testPutObjectAclPublicRead()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'ACL'=>'public-read'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，公共权限非法
     * InvalidArgument
     * 400
     */
    public function testPutObjectAclInvalid()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'ACL'=>'public'
                )
            );
            $this->assertTrue(False);
        } catch (ServiceResponseException $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidArgument' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put object acl，设置object账号权限为grant-read
     * 200
     */
    public function testPutObjectAclReadToUser()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' =>  $this->bucket,
                    'Key' => $this->key,
                    'GrantRead' => 'id="qcs::cam::uin/100018617869:uin/100018617869"'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }


    /*
     * put object acl，设置object账号权限为grant-full-control
     * 200
     */
    public function testPutObjectAclFullToUser()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' =>  $this->bucket,
                    'Key' => $this->key,
                    'GrantFullControl' => 'id="qcs::cam::uin/100018617869:uin/100018617869"'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，设置object账号权限，同时授权给多个账户
     * 200
     */
    public function testPutObjectAclToUsers()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' =>  $this->bucket,
                    'Key' => $this->key,
                    'GrantFullControl' => 'id="qcs::cam::uin/100018617869:uin/100018617869",id="qcs::cam::uin/100018617869:uin/100018617869",id="qcs::cam::uin/100018617869:uin/100018617869"'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，设置object账号权限，授权给子账号
     * 200
     */
    public function testPutObjectAclToSubuser()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' =>  $this->bucket,
                    'Key' => $this->key,
                    'GrantFullControl' => 'id="qcs::cam::uin/100018617869:uin/100018617869"'
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {

            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，设置object账号权限，grant值非法
     * InvalidArgument
     * 400
     */
    public function testPutObjectAclInvalidGrant()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' =>  $this->bucket,
                    'Key' => $this->key,
                    'GrantFullControl' => 'id="qcs::camuin/321023:uin/100018617869"'
                )
            );
            $this->assertTrue(False);
        } catch (ServiceResponseException $e) {
            $this->assertTrue($e->getExceptionCode() === 'InvalidArgument' && $e->getStatusCode() === 400);
        }
    }

    /*
     * put object acl，设置object账号权限，通过body方式授权
     * 200
     */
    public function testPutObjectAclByBody()
    {
        try {
            $this->cosClient->PutObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
                    'Grants' => array(
                        array(
                            'Grantee' => array(
                                'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                                'Type' => 'CanonicalUser',
                            ),
                            'Permission' => 'FULL_CONTROL',
                        ),
                        // ... repeated
                    ),
                    'Owner' => array(
                        'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                        'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                    )
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            
            $this->assertFalse(True);
        }
    }

    /*
     * put object acl，设置object账号权限，通过body方式授权给anyone
     * 200
     */
    public function testPutObjectAclByBodyToAnyone()
    {
        try {
            $this->cosClient->putObjectAcl(
                array(
                    'Bucket' => $this->bucket,
                    'Key' => $this->key,
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
                        'DisplayName' => 'qcs::cam::uin/100018617869:uin/100018617869',
                        'ID' => 'qcs::cam::uin/100018617869:uin/100018617869',
                    )
                )
            );
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            
            $this->assertFalse(True);
        }
    }

    /*
     * get object tagging，object不存在
     * NoSuchKey
     * 404
     */
    public function testPutObjectTaggingObjectNonExisted()
    {
        $tagSet = Common::getTagSet();
        try {
            $this->cosClient->putObjectTagging(
                array(
                    'Bucket' => $this->bucket,
                    'Key'    => $this->key . 'tmp',
                    'TagSet' => $tagSet
                )
            );
            $this->assertTrue(false);
        } catch (ServiceResponseException $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchKey' && $e->getStatusCode() === 404);
        }
    }

    /*
     * append object相关测试
     */
    public function testAppendObject()
    {
        $local_test_key = Common::LOCAL_TEST_FILE;
        Common::generateFile();
        $content_array = array('hello cos', 'hi cos');
        /**
         * 追加上传字符流
         */
        try {
            $position = $this->cosClient->appendObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->appendKey,
                'Position' => 0,
                'Body' => $content_array[0]))['Position'];
            $this->assertEquals($position, strlen($content_array[0]));
            $position = $this->cosClient->appendObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->appendKey,
                'Position' => (integer)$position,
                'Body' => $content_array[1]))['Position'];
            $this->assertEquals($position, strlen($content_array[0]) + strlen($content_array[1]));
        } catch (ServiceResponseException $e) {
            $this->assertFalse(true);
        }

        /**
         * 检查追加上传字符流与下载对象内容是否一致
         */
        try {
            $content = $this->cosClient->getObject(array('Bucket'=>$this->bucket, 'Key'=>$this->appendKey));
            $this->assertEquals($content['Body'], implode($content_array));
        } catch (ServiceResponseException $e) {
            $this->assertFalse(true);
        }


        /**
         * 删除测试对象
         */
        try {
            $this->cosClient->deleteObject(array('Bucket'=>$this->bucket, 'Key'=>$this->appendKey));
        } catch (ServiceResponseException $e) {
            $this->assertFalse(true);
        }

        /**
         * 追加本地文件
         */
        try {
            $position = $this->cosClient->appendObject(array(
                'Bucket' => $this->bucket,
                'Key' => $this->appendKey,
                'Position' => 0,
                'Body' => fopen($local_test_key, 'rb')
            ))['Position'];
            $this->assertEquals($position, filesize($local_test_key));
        } catch (ServiceResponseException $e) {
            $this->assertFalse(true);
        }

        /**
         * 检查追加上传文件与下载对象内容是否一致
         */
        try {
            $md5 = base64_encode(md5(file_get_contents($local_test_key), true));
            $rt = $this->cosClient->getObject(array('Bucket'=>$this->bucket, 'Key'=>$this->appendKey));
            $download_md5 = base64_encode(md5($rt['Body'], true));
            $this->assertEquals($md5, $download_md5);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(true);
        }
    }

    /*
    * 正常put对象标签
    * 200
    */
    public function testPutObjectTagging()
    {
        $tagSet = Common::getTagSet();
        try {
            $this->cosClient->putObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'TagSet' => $tagSet
            ));
            $rt = $this->cosClient->getObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key
            ));
            $this->assertEquals($rt['TagSet'], $tagSet);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 正常get对象标签
     * 200
     */
    public function testGetObjectTagging()
    {
        $tagSet = Common::getTagSet();
        try {
            $this->cosClient->putObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'TagSet' => $tagSet
            ));
            $this->cosClient->getObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 正常delete对象标签
     * 200
     */
    public function testDeleteObjectTagging()
    {
        $tagSet = Common::getTagSet();
        try {
            $this->cosClient->putObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key,
                'TagSet' => $tagSet
            ));
            Common::waitSync();
            $this->cosClient->deleteObjectTagging(array(
                'Bucket' => $this->bucket,
                'Key' => $this->key
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->key = Common::FILE_NAME;
        $this->appendKey = $this->key.'append';
        $this->cosClient->putObject(array('Bucket' => $this->bucket,'Key' => $this->key, 'Body' => '123'));
    }

    protected function tearDown(): void {
        parent::tearDown();
    }

    /*
     * 文本审核
     */
    public function testDetectText()
    {
        try {
            // 文本审核
            $content = '敏感词';
            $this->cosClient->detectText(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Content' => base64_encode($content) // 文本需base64_encode
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads', //Porn,Terrorism,Politics,Ads,Illegal,Abuse类型
                ),
            ));

            // 桶文件审核
            $result = $this->cosClient->detectText(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Object' => 'test01.txt'
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads', //Porn,Terrorism,Politics,Ads,Illegal,Abuse类型
                ),
            ));
            Common::waitSync();
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectTextResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // 文本文件url审核
            $result = $this->cosClient->detectText(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Url' => 'https://bucket-123456.cos.ap-region.myqcloud.com/test01.txt'
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads', //Porn,Terrorism,Politics,Ads,Illegal,Abuse类型
                ),
            ));
            Common::waitSync();
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectTextResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 图片审核
     */
    public function testDetectImage()
    {
        try {
            // 存储桶图片审核
            $this->cosClient->detectImage(array(
                'Bucket' => $this->bucket,
                'Key' => 'test01.png',
                'DetectType' => 'porn,politics,terrorist,ads', //可选四种参数：porn,politics,terrorist,ads，可使用多种规则，注意规则间不要加空格
                'ci-process' => 'sensitive-content-recognition',
            ));

            // 图片url审核
            $result = $this->cosClient->detectImage(array(
                'Bucket' => $this->bucket,
                'Key' => '/', // 链接图片资源路径写 / 即可
                'DetectType' => 'porn,politics,terrorist,ads',
                'DetectUrl' => 'https://wx4.sinaimg.cn/large/0024cZx9ly8guadz67tijj60rs0fg0xv02.jpg',
                'ci-process' => 'sensitive-content-recognition',
            ));

            Common::waitSync();

            // 查看图片审核结果
            $jobId = $result['JobId'];
            $this->cosClient->getDetectImageResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // 批量审核图片
            $this->cosClient->detectImages(array(
                'Bucket' => $this->bucket,
                'Inputs' => array(
                    array(
                        'Object' => 'test01.png',
                    ),
                    array(
                        'Url' => 'https://wx4.sinaimg.cn/large/0024cZx9ly8guadz67tijj60rs0fg0xv02.jpg',
                    ),
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                )
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 音频审核
     */
    public function testDetectAudio()
    {
        try {
            // 桶文件审核
            $result = $this->cosClient->detectAudio(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Object' => 'sound01.mp3',
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                ),
            ));

            Common::waitSync();

            // 查看音频审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectAudioResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // 音频url审核
            $result = $this->cosClient->detectAudio(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Url' => 'http://mpge.5nd.com/2019/2019-5-17/91703/2.mp3',
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                ),
            ));

            Common::waitSync();

            // 查看音频审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectAudioResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));
            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 视频审核
     */
    public function testDetectVideo()
    {
        try {
            // 桶文件审核
            $result = $this->cosClient->detectVideo(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Object' => 'video01.mp4', // 存储桶文件
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                    'Snapshot' => array(
                        'Count' => '3',
                    ),
                ),
            ));

            Common::waitSync();

            // 查看视频审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectVideoResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // 视频url审核
            $result = $this->cosClient->detectVideo(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Url' => 'https://vd2.bdstatic.com/mda-mi699c6pfpap5i0h/fhd/cae_h264_nowatermark/1630996539537195871/mda-mi699c6pfpap5i0h.mp4',
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                    'Snapshot' => array(
                        'Count' => '3',
                    ),
                ),
            ));

            Common::waitSync();

            // 查看视频审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectVideoResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 文档审核
     */
    public function testDetectDocument()
    {
        try {
            // 桶文件审核
            $result = $this->cosClient->detectDocument(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Object' => 'test01.docx',
                    'Type' => 'docx',
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                ),
            ));

            Common::waitSync();

            // 查看文档审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectDocumentResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // 文档url审核
            $result = $this->cosClient->detectDocument(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Url' => 'http://e.sinajs.cn/tui/docs/guiding.pdf',
                    'Type' => 'pdf',
                ),
                'Conf' => array(
                    'DetectType' => 'Porn,Terrorism,Politics,Ads',
                ),
            ));

            Common::waitSync();

            // 查看文档审核结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectDocumentResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

    /*
     * 云查毒
     */
    public function testDetectVirus()
    {
        try {
            // 桶文件审核
            $result = $this->cosClient->detectVirus(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Object' => 'test01.docx'
                ),
                'Conf' => array(
                    'DetectType' => 'Virus',
                ),
            ));

            Common::waitSync();

            // 查看云查毒结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectVirusResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            // url查毒
            $result = $this->cosClient->detectVirus(array(
                'Bucket' => $this->bucket,
                'Input' => array(
                    'Url' => 'http://e.sinajs.cn/tui/docs/guiding.pdf',
                ),
                'Conf' => array(
                    'DetectType' => 'Virus',
                ),
            ));

            Common::waitSync();

            // 查看云查毒结果
            $jobId = $result['JobsDetail']['JobId'];
            $this->cosClient->getDetectVirusResult(array(
                'Bucket' => $this->bucket,
                'Key' => $jobId,
            ));

            $this->assertTrue(True);
        } catch (ServiceResponseException $e) {
            $this->assertFalse(True);
        }
    }

}