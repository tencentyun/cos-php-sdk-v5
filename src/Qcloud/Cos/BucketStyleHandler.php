<?php

namespace Qcloud\Cos;

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Exception\CommandException;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Command\Guzzle\SchemaValidator;

class BucketStyleHandler {
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function __invoke(callable $handler) {
        return function (CommandInterface $command) use ($handler) {
            // $operation = $this->description->getOperation($command->getName());
            // $action = $command->getName();
            // $api = $this->client->getApi();
            // $cosConfig = $this->client->getCosConfig();
            // $operation = $api[$action];
            // if ($action == "GetService") {

            // } else {
            //     $bucketname = $command['Bucket'];
            //     $path = ''; 
            //     $http_method = $operation['httpMethod'];
            //     $uri = $operation['uri'];
            //     if (isset($operation['parameters']['Bucket']) && $command->hasParam('Bucket')) {
            //         $uri = str_replace("{Bucket}", '', $uri);
            //     }   
            //     if (isset($operation['parameters']['Key']) && $command->hasParam('Key')) {
            //         $uri = str_replace("{/Key*}", $command['Key'], $uri);
            //     } 
            //     $host = $bucketname. '.cos.' . $cosConfig['region'] .'.myqcloud.com';
            //     $path = $cosConfig['schema'].'://'. $host . $uri;
                $handler->getHandlerStack()->push(Middleware::mapRequest(function (RequestInterface $request) {
                    return $request->withHeader('X-Foo-AAAAA', 'Bar');
                }));
                    // $request = new Psr7\Request($http_method, $path, [], '');
                // return $handler($command);
            // }
            return $handler($command);
        };
    }
}
