<?php

require 'vendor/autoload.php';

$cosClient = new Qcloud\Cos\Client(array(
    'region' => 'ap-chengdu',
    'credentials' => array(
        'secretId' => 'AKIDOiu3732V6Zt6PuPckiWD2IS7eIwu7tx1',
        'secretKey' => '990hJantqjXDtCPSmGxt08JPM9OZbVNA',
    ),
));

$bucket = 'abc-1251081331';
$key = 'hello.txt';

try {
    $result = $cosClient->putObject(array(
        'Bucket' => $bucket,
        'Key' => $key,
        'Body' => "Hello World!\n"
    ));
    print_r($result);
    # 可以直接通过$result读出返回结果
    echo ($result['ETag']);
} catch (Qcloud\Cos\Exception\ServiceResponseException $e) {
	echo "ZZZ\n";
	echo $e->getMessage();
	echo $e->getCosRequestId();
} catch (RuntimeException $e) {
	echo "###\n";
	echo $e->getMessage() . "\n";
	//echo($e);
} catch (Exception $e) {
	echo "111\n";
	//echo($e);
	echo "222\n";
}

