<?php

namespace Qcloud\Cos\Tests;

use Qcloud\Cos\Client;
use Qcloud\Cos\Exception\CosException;

class BucketTest extends \PHPUnit_Framework_TestCase {
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

    public function testCreateBucket() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testCreateAlreadyExistedBucket() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
        } catch (CosException $e) {
            $this->assertTrue($e->getExceptionCode() === 'BucketAlreadyExists');
            $this->assertTrue($e->getStatusCode() === 409);
        }
    }

    public function testDeleteBucket() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
            $result = $this->cosClient->deleteBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

    public function testDeleteNonexistedBucket() {
        try {
            $result = $this->cosClient->deleteBucket(array('Bucket' => 'testbucket'));
            var_dump($result);
            sleep(2);
        } catch (CosException $e) {
            $this->assertTrue($e->getExceptionCode() === 'NoSuchBucket');
            $this->assertTrue($e->getStatusCode() === 404);
        }
    }

    public function testDeleteNonemptyBucket() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(2);
            $this->cosClient->putObject(array(
                        'Bucket' => 'testbucket', 'Key' => 'hello.txt', 'Body' => 'Hello World!'));
            $this->cosClient->deleteBucket(array('Bucket' => 'testbucket'));
        } catch (CosException $e) {
            echo "$e\n";
            echo $e->getExceptionCode();
            $this->assertTrue($e->getExceptionCode() === 'BucketNotEmpty');
            $this->assertTrue($e->getStatusCode() === 409);
        }
    }
}
