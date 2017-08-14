<?php

namespace Qcloud\Cos\Tests;

use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\CosException;

class ObjectTest extends \PHPUnit_Framework_TestCase {
    private $cosClient;

    protected function setUp() {
        TestHelper::nuke('testbucket');

        $this->cosClient = new Client(array('region' => getenv('COS_REGION'),
            'key' => getenv('COS_KEY'),
            'credentials'=> array(
                'appId' => getenv('COS_APPID'),
                'secretId'    => getenv('COS_KEY'),
                'secretKey' => getenv('COS_SECRET'))));
    }



    protected function tearDown() {
        TestHelper::nuke('testbucket-1252448703');
    }

    public function testPutObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
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
            $this->cosClient->upload('testbucket', 'hello.txt', 'Hello World');
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testUploadLargeObject() {
        try {
            $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            $this->cosClient->upload($bucket='testbucket', $key='hello.txt', $body=str_repeat('a', 20 * 1024 * 1024));
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }
}