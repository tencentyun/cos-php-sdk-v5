<?php

namespace Qcloud\Cos;

use Qcloud\Cos\Signature;
use Qcloud\Cos\TokenListener;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Deserializer;
use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Exception\CommandException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;


class Client extends GuzzleClient {
    const VERSION = '2.0.0';

    private $httpCilent;
    private $api;
    private $cosConfig;
    private $signature;

    public function __construct($cosConfig) {
        $this->cosConfig['schema'] = isset($cosConfig['schema']) ? $cosConfig['schema'] : 'http';
        $this->cosConfig['ip'] = isset($cosConfig['ip']) ? $cosConfig['ip'] : null;
        $this->cosConfig['port'] = isset($cosConfig['port']) ? $cosConfig['port'] : null;
        $this->cosConfig['endpoint'] = isset($cosConfig['endpoint']) ? $cosConfig['endpoint'] : null;
        $this->cosConfig['region'] =  isset($regionmap[$cosConfig['region']]) ? region_map($cosConfig['region']) : $cosConfig['region'];
        $this->cosConfig['appId'] = isset($cosConfig['credentials']['appId']) ? $cosConfig['credentials']['appId'] : null;
        $this->cosConfig['secretId'] = $cosConfig['credentials']['secretId'];
        $this->cosConfig['secretKey'] = $cosConfig['credentials']['secretKey'];
        $this->cosConfig['token'] = isset($cosConfig['credentials']['token']) ? $cosConfig['credentials']['token'] : null;
        $this->cosConfig['timeout'] = isset($cosConfig['timeout']) ? $cosConfig['timeout'] : 3600;
        $this->cosConfig['connect_timeout'] = isset($cosConfig['connect_timeout']) ? $cosConfig['connect_timeout'] : 3600;
        
        $service = Service::getService();
        $handler = HandlerStack::create();
		$handler->push(Middleware::mapRequest(function (RequestInterface $request) {
			return $request->withHeader('User-Agent', 'cos-php-sdk-v5.'. Client::VERSION);
		}));
		$handler->push($this::handleSignature($this->cosConfig['secretId'], $this->cosConfig['secretKey']));
        $handler->push($this::handleErrors());
        $this->signature = new Signature($this->cosConfig['secretId'], $this->cosConfig['secretKey']);
        $this->httpClient = new HttpClient([
            'base_uri' => $this->cosConfig['schema'].'://cos.' . $this->cosConfig['region'] . '.myqcloud.com/',
			'handler' => $handler,
        ]);
        $this->desc = new Description($service);
        $this->api = (array)($this->desc->getOperations());
        parent::__construct($this->httpClient, $this->desc, [$this,
        'commandToRequestTransformer'], [$this, 'responseToResultTransformer'],
        null);
        // parent::__construct($this->httpClient, $this->desc, new Serializer($this->desc, []));
		// $stack = $this->getHandlerStack();
		// $stack->push(new BucketStyleHandler($this), 'bucket_style');
    }

    public function commandToRequestTransformer(CommandInterface $command)
    {
        $action = $command->GetName();
        $opreation = $this->api[$action];
        $transformer = new CosTransformer($this->cosConfig, $opreation); 
        $seri = new Serializer($this->desc);
        $request = $seri($command);
        $request = $transformer->bucketStyleTransformer($command, $request);
        $request = $transformer->uploadBodyTransformer($command, $request);
        $request = $transformer->md5Transformer($command, $request);
        return $request;
    }

    public function responseToResultTransformer(ResponseInterface $response, RequestInterface $request, CommandInterface $command)
    {
        $deseri = new Deserializer($this->desc, true);
        $response = $deseri($response, $request, $command);
        return $response;
    }
    public function __destruct() {
    }

    public function __call($method, $args) {
        try {
            return parent::__call(ucfirst($method), $args);
		} catch (CommandException $e) {
            $previous = $e->getPrevious();
			if ($previous !== null) {
				throw $previous;
			} else {
                throw $e;
            }
        }
    }

    public function getApi() {
        return $this->api;
    }

    private function getCosConfig() {
        return $this->cosConfig;
    }

    private function createPresignedUrl(RequestInterface $request, $expires) {
        return $this->signature->createPresignedUrl($request, $expires);
    }

    public function getPresignetUrl($method, $args) {
        $command = $this->getCommand($method, $args);
        $request = $this->commandToRequestTransformer($command);
        return $expires ? $this->createPresignedUrl($request, $expires) : $request->getUrl();
    }

    public function getObjectUrl($bucket, $key, $expires = null, array $args = array()) {
        $command = $this->getCommand('GetObject', $args + array('Bucket' => $bucket, 'Key' => $key));
        $request = $this->commandToRequestTransformer($command);
        return $expires ? $this->createPresignedUrl($request, $expires) : $request->getUrl();
    }

    public function upload($bucket, $key, $body, $options = array()) {
        $body = Psr7\stream_for($body);
        $options = array_change_key_case($options);
        $options['min_part_size'] = isset($options['min_part_size']) ? $options['min_part_size'] : MultipartUpload::MIN_PART_SIZE;
        if ($body->getSize() < $options['min_part_size']) {
            // Perform a simple PutObject operation
            $rt = $this->putObject(array(
                    'Bucket' => $bucket,
                    'Key'    => $key,
                    'Body'   => $body,
                ) + $options);
        }
        else {
            $multipartUpload = new MultipartUpload($this, $body, array(
                    'Bucket' => $bucket,
                    'Key' => $key,
                ) + $options);

            $rt = $multipartUpload->performUploading();
        }
        return $rt;
    }

    public function resumeUpload($bucket, $key, $body, $uploadId, $options = array()) {
        $body = Psr7\stream_for($body);
        $options = array_change_key_case($options);
        $options['min_part_size'] = isset($options['min_part_size']) ? $options['min_part_size'] : MultipartUpload::MIN_PART_SIZE;
        $multipartUpload = new MultipartUpload($this, $body, array(
                'Bucket' => $bucket,
                'Key' => $key,
            ) + $options);

        $rt = $multipartUpload->resumeUploading();
        return $rt;
    }

    public function copy($bucket, $key, $copysource, $options = array()) {

        $options = Collection::fromConfig(array_change_key_case($options), array(
            'min_part_size' => Copy::MIN_PART_SIZE,
            'params'        => $options));
        $sourcelistdot  =  explode('.',$copysource);
        $sourcelistline = explode('-',$sourcelistdot[0]);
        $sourceappid = array_pop($sourcelistline);
        $sourcebucket = implode('-', $sourcelistline);
        $sourceregion = $sourcelistdot[2];
        $sourcekey = substr(strstr($copysource,'/'),1);
        $sourceversion = "";
        $sourceconfig = $this->cosConfig;
        $sourceconfig['region'] = $sourceregion;
        $sourceconfig['credentials']['appId'] = $sourceappid;
        $cosClient = new Client($sourceconfig);
        if (!key_exists('VersionId',$options['params'])) {
            $sourceversion = "";
        }
        else {
            $sourceversion = $options['params']['VersionId'];
        }
        $rt = $cosClient->headObject(array('Bucket'=>$sourcebucket,
            'Key'=>$sourcekey,
            'VersionId'=>$sourceversion));
        $contentlength =$rt['ContentLength'];

        if ($contentlength < $options['min_part_size']) {
            return $this->copyObject(array(
                    'Bucket' => $bucket,
                    'Key'    => $key,
                    'CopySource'   => $copysource."?versionId=".$sourceversion,
                ) + $options['params']);
        }
        $copy = new Copy($this, $contentlength, $copysource."?versionId=".$sourceversion, $options['min_part_size'], array(
                'Bucket' => $bucket,
                'Key'    => $key
            ) + $options['params']);

        return $copy->copy();
    }

    public function doesBucketExist($bucket, $accept403 = true, array $options = array())
    {
        try {
            $this->HeadBucket(array(
                'Bucket' => $bucket));
            return True;
        }catch (\Exception $e){
            return False;
        }
    }

    public function doesObjectExist($bucket, $key, array $options = array())
    {
        try {
            $this->HeadObject(array(
                'Bucket' => $bucket,
                'Key' => $key));
            return True;
        }catch (\Exception $e){
            return False;
        }
    }
    
    public static function explodeKey($key) {
        // Remove a leading slash if one is found
        $split_key = explode('/', $key && $key[0] == '/' ? substr($key, 1) : $key);
        // Remove empty element
        $split_key = array_filter($split_key);
        return implode("/", $split_key);
    }

	public static function handleSignature($secretId, $secretKey) {
		return function (callable $handler) use ($secretId, $secretKey) {
			return new SignatureMiddleware($handler, $secretId, $secretKey);
		};
	}

	public static function handleErrors() {
		return function (callable $handler) {
			return new ExceptionMiddleware($handler);
		};
	}
}
