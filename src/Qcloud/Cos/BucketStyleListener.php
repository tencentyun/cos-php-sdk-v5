<?php

namespace Qcloud\Cos;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Change from path style to host style, currently only host style is supported in cos.
 */
function endWith($haystack, $needle) {
    $length = strlen($needle);
    if($length == 0)
    {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}
class BucketStyleListener implements EventSubscriberInterface {

    private $appId;  // string: application id.

    public function __construct($appId) {
        $this->appId = $appId;
    }

    public static function getSubscribedEvents() {
        return array('command.after_prepare' => array('onCommandAfterPrepare', -230));
    }

    /**
     * Change from path style to host style.
     * @param Event $event Event emitted.
     */
    public function onCommandAfterPrepare(Event $event) {
        $command = $event['command'];
        $bucket = $command['Bucket'];
        $request = $command->getRequest();

        if ($command->getName() == 'ListBuckets')
        {
            $request->setHost('service.cos.myqcloud.com');
            return ;
        }
        if ($key = $command['Key']) {
            // Modify the command Key to account for the {/Key*} explosion into an array
            if (is_array($key)) {
                $command['Key'] = $key = implode('/', $key);
            }
        }
        $request->setHeader('Date', gmdate('D, d M Y H:i:s T'));
        $request->setPath(preg_replace("#^/{$bucket}#", '', $request->getPath()));

        if ($this->appId != null && endWith($bucket,'-'.$this->appId) == False)
        {
            $bucket = $bucket.'-'.$this->appId;
        }
        // Set the key and bucket on the request
        $request->getParams()->set('bucket', $bucket)->set('key', $key);

        //$request->setPath(urldecode($request->getPath()));
        // Switch to virtual hosted bucket
        $request->setHost($bucket. '.' . $request->getHost());
        if (!$bucket) {
            $request->getParams()->set('cos.resource', '/');
        } else {
            // Bucket style needs a trailing slash
            $request->getParams()->set(
                'cos.resource',
                '/' . rawurlencode($bucket) . ($key ? ('/' . Client::encodeKey($key)) : '/')
            );
        }
    }
}
