<?php

namespace Qcloud\Cos;

use Aws\Common\Credentials\CredentialsInterface;
use Aws\Common\Credentials\NullCredentials;
use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener used to sign requests before they are sent over the wire.
 */
class GetServiceListener implements EventSubscriberInterface {
    // cos signature.

    /**
     * Construct a new request signing plugin
     */
    public function __construct() {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send'        => array('onRequestBeforeSend', -253));
    }

    /**
     * Signs requests before they are sent
     *
     * @param Event $event Event emitted
     */
    public function onRequestBeforeSend(Event $event) {
        if($event['request']->getPath() == '/' && $event['request']->getMethod() == 'GET')
        {$event['request']->setUrl('http://service.cos.myqcloud.com');}
/*
        if(!$this->credentials instanceof NullCredentials) {
            $this->signature->signRequest($event['request'], $this->credentials);
        }
*/
    }
}
