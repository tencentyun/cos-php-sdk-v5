<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'cos-autoloader.php');

$cosClient = new Qcloud\Cos\Client(
                            array(
                            'region' => '',
                            'timeout' => 1000,
                            'credentials'=> array(
                                'appId' => '',
                                'secretId'    => '',
                                'secretKey' => '')));
#createBucket
try {
    $result = $cosClient->createBucket(array('Bucket' => 'testbucket'));
    var_dump($result);
    } catch (\Exception $e) {
    echo "$e\n";
}

#uploadbigfile
try {
    $result = $cosClient->upload(
                 'testbucket',
                 '111.txt',
        str_repeat('a', 20 * 1024 * 1024));
    var_dump($result);
    } catch (\Exception $e) {
    echo "$e\n";
}

#putObject
try {
    $result = $cosClient->putObject(array(
        'Bucket' => 'testbucket',
        'Key' => '111',
        'Body' => 'Hello World!'));
    var_dump($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#putObject
try {
    $result = $cosClient->getObject(array(
        'Bucket' => 'testbucket',
        'Key' => '111',
        'Body' => 'Hello World!'));
    var_dump($result);
} catch (\Exception $e) {
    echo "$e\n";
}

#deleteObject
try {
    $result = $cosClient->deleteObject(array(
        'Bucket' => 'testbucket',
        'Key' => '111'));
    var_dump($result);
} catch (\Exception $e) {
    echo "$e\n";
}


#deleteBucket
try {
    $result = $cosClient->deleteBucket(array(
        'Bucket' => 'testbucket'));
    var_dump($result);
} catch (\Exception $e) {
    echo "$e\n";
}
$bucket =  'lewzylu02';
$key = 'hello.txt';
$region = 'cn-south';
$url = "/{$key}";

// get() returns a Guzzle\Http\Message\Request object
$request = $cosClient->get($url);
// Create a signed URL from a completely custom HTTP request that
// will last for 10 minutes from the current time
$signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');

echo ($signedUrl);
