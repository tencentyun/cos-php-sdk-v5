<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'cos-autoloader.php');

$cosClient = new Qcloud\Cos\Client(
                            array('region' => 'cn-north',
                            'credentials'=> array(
                            'appId' => '1252448703',
                            'secretId'    => 'AKID15IsskiBQKTZbAo6WhgcBqVls9SmuG00',
                            'secretKey' => 'ciivKvnnrMvSvQpMAWuIz12pThGGlWRW'),
                            'timeout' => 1
                            )
);

try {
    //$result = $cosClient->createBucket(array('Bucket' => 'testbucket1-1252448703'));
    //var_dump($result);
    $data = file_get_contents("111.txt");
    $result = $cosClient->upload(
                'testbucket',
                 '111.txt',
                 "111");
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