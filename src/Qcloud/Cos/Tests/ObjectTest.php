<?php

namespace Qcloud\Cos\Tests;

use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\CosException;

class ObjectTest extends \PHPUnit_Framework_TestCase {
    private $cosClient;

    protected function setUp() {
        TestHelper::nuke('testbucket');

        $this->cosClient = new Client(array('region' => getenv('COS_REGION'),
                'credentials'=> array(
                'appId' => getenv('COS_APPID'),
                'secretId'    => getenv('COS_KEY'),
                'secretKey' => getenv('COS_SECRET'))));
    }



    protected function tearDown() {
        TestHelper::nuke('testbucket');
        sleep(2);
    }

    public function testPutObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(2);
            $this->cosClient->putObject(array(
                        'Bucket' => 'testbucket', 'Key' => 'hello.txt', 'Body' => 'Hello World'));
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testPutObjectIntoNonexistedBucket() {
        try {
            $this->cosClient->putObject(array(
                        'Bucket' => '000testbucket', 'Key' => 'hello.txt', 'Body' => 'Hello World'));
        } catch (CosException $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket');
            $this->assertTrue($e->getStatusCode() === 404);
        }
    }

    public function testUploadSmallObject() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
            $this->cosClient->upload('testbucket', '你好.txt', 'Hello World');
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testUploadComplexObject() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
            $this->cosClient->upload('testbucket', '→↓←→↖↗↙↘! \"#$%&\'()*+,-./0123456789:;<=>@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~', 'Hello World');
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testUploadLargeObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(5);
            $this->cosClient->upload('testbucket', 'hello.txt', str_repeat('a', 20 * 1024 * 1024));
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testGetObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(5);
            $this->cosClient->upload('testbucket', '你好.txt', 'Hello World');
            $this->cosClient->getObject(array(
                                    'Bucket' => 'testbucket',
                                    'Key' => '你好.txt',));
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testGetObjectUrl() {
        try{
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            $this->cosClient->getObjectUrl('testbucket', 'hello.txt', '+10 minutes');
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testPutObjectACL() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(5);
            $this->cosClient->upload('testbucket', '11', 'hello.txt');
            $this->cosClient->PutObjectAcl(array(
                'Bucket' => 'testbucket',
                'Key' => '11',
                'Grants' => array(
                    array(
                        'Grantee' => array(
                            'DisplayName' => 'string',
                            'ID' => 'qcs::cam::uin/123:uin/123',
                        ),
                        'Permission' => 'FULL_CONTROL',
                    ),
                    // ... repeated
                ),
                'Owner' => array(
                    'ID' => 'qcs::cam::uin/123:uin/123',
                ),));
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }

    }
    public function testGetObjectACL()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(5);
            $this->cosClient->upload('testbucket', '11', 'hello.txt');
            $this->cosClient->PutObjectAcl(array(
                'Bucket' => 'testbucket',
                'Key' => '11',
                'Grants' => array(
                    array(
                        'Grantee' => array(
                            'DisplayName' => 'string',
                            'ID' => 'qcs::cam::uin/123:uin/123',
                        ),
                        'Permission' => 'FULL_CONTROL',
                    ),
                    // ... repeated
                ),
                'Owner' => array(
                    'ID' => 'qcs::cam::uin/123:uin/123',
                ),));
            $this->cosClient->GetObjectAcl(array(
                'Bucket' => 'testbucket',
                'Key' => '11'));

        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }
    public function testDeleteObjectACL()
    {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(5);
            $this->cosClient->upload('testbucket', '11', 'hello.txt');
            $this->cosClient->PutObjectAcl(array(
                'Bucket' => 'testbucket',
                'Key' => '11',
                'Grants' => array(
                    array(
                        'Grantee' => array(
                            'DisplayName' => 'string',
                            'ID' => 'qcs::cam::uin/123:uin/123',
                        ),
                        'Permission' => 'FULL_CONTROL',
                    ),
                    // ... repeated
                ),
                'Owner' => array(
                    'ID' => 'qcs::cam::uin/123:uin/123',
                ),));
            $this->cosClient->DeleteObjectAcl(array(
                'Bucket' => 'testbucket',
                'Key' => '11'));

        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }
}
