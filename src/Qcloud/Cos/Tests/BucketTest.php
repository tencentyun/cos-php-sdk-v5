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
            $result = $this->cosClient->putObject(array(
                        'Bucket' => 'testbucket', 'Key' => 'hello.txt', 'Body' => 'Hello World!'));
            $result = $this->cosClient->deleteBucket(array('Bucket' => 'testbucket'));
        } catch (CosException $e) {
            echo "$e\n";
            echo $e->getExceptionCode();
            $this->assertTrue($e->getExceptionCode() === 'BucketNotEmpty');
            $this->assertTrue($e->getStatusCode() === 409);
        }
    }
    public function testPutBucketLifecycle() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(2);
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => 'testbucket',
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
            var_dump($result);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }
    public function testGetBucketLifecycle() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(2);
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => 'testbucket',
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
            sleep(5);
            $result = $this->cosClient->getBucketLifecycle(array(
                // Bucket is required
                'Bucket' => 'testbucket',
                ));
            var_dump($result);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }
    public function testDeleteBucketLifecycle() {
        try {
            $result = $this->cosClient->createBucket(array('Bucket' => 'testbucket'));
            sleep(2);
            $result = $this->cosClient->putBucketLifecycle(array(
                // Bucket is required
                'Bucket' => 'testbucket',
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
            sleep(5);
            $result = $this->cosClient->deleteBucketLifecycle(array(
                // Bucket is required
                'Bucket' => 'testbucket',
            ));
            var_dump($result);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e);
        }
    }

}
