<?php

namespace Qcloud\Cos;

/**
 * 为 src/Qcloud/Cos/Service.php 服务，视觉上区分各方法的参数\输出描述
 * 原service的参数描述可不改动
 * Class Descriptions
 * @package Qcloud\Cos
 */
class Descriptions {
    /**
     * 视频转码
     * @return array
     */
    public static function CreateMediaTranscodeJobs() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}jobs',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'CreateMediaTranscodeJobsOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'uri', ),
                'Tag' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'QueueId' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'CallBack' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'Input' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
                'Operation' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'TemplateId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'WatermarkTemplateId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'Transcode' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Container' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Format' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'Video' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Codec' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Width' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Height' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Fps' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Remove' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Profile' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Bitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Crf' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Gop' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Preset' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Bufsize' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Maxrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'HlsTsTime' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Pixfmt' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'LongShortMode' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'TimeInterval' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Start' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Duration' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'Audio' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Codec' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Samplerate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Bitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Channels' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Remove' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'KeepTwoTracks' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'SwitchTrack' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'SampleFormat' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'TransConfig' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'AdjDarMethod' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'IsCheckReso' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'ResoAdjMethod' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'IsCheckVideoBitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'VideoBitrateAdjMethod' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'IsCheckAudioBitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'AudioBitrateAdjMethod' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'DeleteMetadata' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'IsHdr2Sdr' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'HlsEncrypt' => array(
                                            'type' => 'object',
                                            'location' => 'xml',
                                            'properties' => array(
                                                'IsHlsEncrypt' => array( 'type' => 'string', 'location' => 'xml', ),
                                                'UriKey' => array( 'type' => 'string', 'location' => 'xml', ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'Watermark' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Type' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Pos' => array( 'type' => 'string', 'location' => 'xml', ),
                                'LocMode' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Dx' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Dy' => array( 'type' => 'string', 'location' => 'xml', ),
                                'StartTime' => array( 'type' => 'string', 'location' => 'xml', ),
                                'EndTime' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Image' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Url' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Mode' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Width' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Height' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Transparency' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Background' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'Text' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'FontSize' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'FontType' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'FontColor' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Transparency' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Text' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                            ),
                        ),
                        'RemoveWatermark' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Dx' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Dy' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Width' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Height' => array( 'type' => 'string', 'location' => 'xml', ),
                            ),
                        ),
                        'Output' => array(
                            'required' => true,
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Region' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public static function CreateMediaTranscodeJobsOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }

    public static function CreateMediaSnapshotJobs() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}jobs',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'CreateMediaSnapshotJobsOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'uri', ),
                'Tag' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'QueueId' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'CallBack' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'Input' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
                'Operation' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'TemplateId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'Output' => array(
                            'required' => true,
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Region' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                            ),
                        ),
                        'Snapshot' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Mode' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Start' => array( 'type' => 'string', 'location' => 'xml', ),
                                'TimeInterval' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Count' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Width' => array( 'type' => 'string', 'location' => 'xml', ),
                                'Height' => array( 'type' => 'string', 'location' => 'xml', ),
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public static function CreateMediaSnapshotJobsOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }

    public static function CreateMediaConcatJobs() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}jobs',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'CreateMediaConcatJobsOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'uri', ),
                'Tag' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'QueueId' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'CallBack' => array( 'required' => true, 'location' => 'xml', 'type' => 'string', ),
                'Input' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
                'Operation' => array(
                    'required' => true,
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'TemplateId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'Output' => array(
                            'required' => true,
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Region' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Bucket' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                                'Object' => array( 'required' => true, 'type' => 'string', 'location' => 'xml', ),
                            ),
                        ),
                        'ConcatTemplate' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'Audio' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Codec' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Samplerate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Bitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Channels' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'Index' => array( 'type' => 'string', 'location' => 'xml', ),
                                'ConcatFragments' => array(
                                    'type' => 'array',
                                    'location' => 'xml',
                                    'data' => array(
                                        'xmlFlattened' => true,
                                    ),
                                    'items' => array(
                                        'name' => 'ConcatFragment',
                                        'type' => 'object',
                                        'sentAs' => 'ConcatFragment',
                                        'properties' => array(
                                            'Url' => array( 'type' => 'string', 'location' => 'xml', ),
                                            'StartTime' => array( 'type' => 'string', 'location' => 'xml', ),
                                            'EndTime' => array( 'type' => 'string', 'location' => 'xml', ),
                                            'Mode' => array( 'type' => 'string', 'location' => 'xml', ),
                                        ),
                                    ),
                                ),
                                'Video' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Codec' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Width' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Height' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Fps' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Bitrate' => array( 'type' => 'string', 'location' => 'xml', ),
                                        'Remove' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                                'Container' => array(
                                    'type' => 'object',
                                    'location' => 'xml',
                                    'properties' => array(
                                        'Format' => array( 'type' => 'string', 'location' => 'xml', ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public static function CreateMediaConcatJobsOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }

    public static function DetectAudio() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}audio/auditing',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'DetectAudioOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Input' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'Url' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'Object' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                    ),
                ),
                'Conf' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'DetectType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'Callback' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'BizType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'CallbackVersion' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                    ),
                ),
            ),
        );
    }
    public static function DetectAudioOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'RequestId' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'x-ci-request-id', ),
                'ContentType' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'Content-Type', ),
                'ContentLength' => array( 'type' => 'numeric', 'minimum'=> 0, 'location' => 'header', 'sentAs' => 'Content-Length', ),
                'JobsDetail' => array(
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'JobId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'State' => array( 'type' => 'string', 'location' => 'xml', ),
                        'CreationTime' => array( 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
            ),
        );
    }

    public static function GetDetectAudioResult() {
        return array(
            'httpMethod' => 'GET',
            'uri' => '/{Bucket}audio/auditing/{/Key*}',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'GetDetectAudioResultOutput',
            'responseType' => 'model',
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Key' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
            ),
        );
    }

    public static function GetDetectAudioResultOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }

    public static function GetDetectTextResult() {
        return array(
            'httpMethod' => 'GET',
            'uri' => '/{Bucket}text/auditing/{/Key*}',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'GetDetectTextResultOutput',
            'responseType' => 'model',
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Key' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
            ),
        );
    }
    public static function GetDetectTextResultOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
                'JobsDetail' => array(
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'Code' => array(
                            'type' => 'string',
                        ),
                        'Message' => array(
                            'type' => 'string',
                        ),
                        'JobId' => array(
                            'type' => 'string',
                        ),
                        'State' => array(
                            'type' => 'string',
                        ),
                        'CreationTime' => array(
                            'type' => 'string',
                        ),
                        'Object' => array(
                            'type' => 'string',
                        ),
                        'SectionCount' => array(
                            'type' => 'string',
                        ),
                        'Result' => array(
                            'type' => 'string',
                        ),
                        'PornInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'TerrorismInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'PoliticsInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'AdsInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'IllegalInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'AbuseInfo' => array(
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => array(
                                'HitFlag' => array(
                                    'type' => 'integer',
                                ),
                                'Count' => array(
                                    'type' => 'integer',
                                ),
                            ),
                        ),
                        'Section' => array(
                            'type' => 'array',
                            'location' => 'xml',
                            'items' => array(
                                'type' => 'object',
                                'properties' => array(
                                    'StartByte' => array(
                                        'type' => 'string',
                                    ),
                                    'PornInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                    'TerrorismInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                    'PoliticsInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                    'AdsInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                    'IllegalInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                    'AbuseInfo' => array(
                                        'type' => 'object',
                                        'location' => 'xml',
                                        'properties' => array(
                                            'HitFlag' => array(
                                                'type' => 'integer',
                                            ),
                                            'Score' => array(
                                                'type' => 'integer',
                                            ),
                                            'Keywords' => array(
                                                'type' => 'string',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public static function DetectVideo() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}video/auditing',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'DetectVideoOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Input' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'Object' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                    ),
                ),
                'Conf' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'DetectType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'Callback' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'BizType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'CallbackVersion' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'DetectContent' => array(
                            'type' => 'integer',
                            'location' => 'xml',
                        ),
                        'Snapshot' => array(
                            'location' => 'xml',
                            'type' => 'object',
                            'properties' => array(
                                'Mode' => array(
                                    'type' => 'string',
                                    'location' => 'xml',
                                ),
                                'Count' => array(
                                    'type' => 'string',
                                    'location' => 'xml',
                                ),
                                'TimeInterval' => array(
                                    'type' => 'number',
                                    'location' => 'xml',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
    }
    public static function DetectVideoOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'RequestId' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'x-ci-request-id', ),
                'ContentType' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'Content-Type', ),
                'ContentLength' => array( 'type' => 'numeric', 'minimum'=> 0, 'location' => 'header', 'sentAs' => 'Content-Length', ),
                'JobsDetail' => array(
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'JobId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'State' => array( 'type' => 'string', 'location' => 'xml', ),
                        'CreationTime' => array( 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
            ),
        );
    }

    public static function GetDetectVideoResult() {
        return array(
            'httpMethod' => 'GET',
            'uri' => '/{Bucket}video/auditing/{/Key*}',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'GetDetectVideoResultOutput',
            'responseType' => 'model',
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Key' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
            ),
        );
    }
    public static function GetDetectVideoResultOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }

    public static function DetectDocument() {
        return array(
            'httpMethod' => 'POST',
            'uri' => '/{Bucket}document/auditing',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'DetectDocumentOutput',
            'responseType' => 'model',
            'data' => array(
                'xmlRoot' => array(
                    'name' => 'Request',
                ),
            ),
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Input' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'Url' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'Type' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                    ),
                ),
                'Conf' => array(
                    'location' => 'xml',
                    'type' => 'object',
                    'properties' => array(
                        'DetectType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'Callback' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                        'BizType' => array(
                            'type' => 'string',
                            'location' => 'xml',
                        ),
                    ),
                ),
            ),
        );
    }
    public static function DetectDocumentOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'RequestId' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'x-ci-request-id', ),
                'ContentType' => array( 'type' => 'string', 'location' => 'header', 'sentAs' => 'Content-Type', ),
                'ContentLength' => array( 'type' => 'numeric', 'minimum'=> 0, 'location' => 'header', 'sentAs' => 'Content-Length', ),
                'JobsDetail' => array(
                    'type' => 'object',
                    'location' => 'xml',
                    'properties' => array(
                        'JobId' => array( 'type' => 'string', 'location' => 'xml', ),
                        'State' => array( 'type' => 'string', 'location' => 'xml', ),
                        'CreationTime' => array( 'type' => 'string', 'location' => 'xml', ),
                    ),
                ),
            ),
        );
    }

    public static function GetDetectDocumentResult() {
        return array(
            'httpMethod' => 'GET',
            'uri' => '/{Bucket}document/auditing/{/Key*}',
            'class' => 'Qcloud\\Cos\\Command',
            'responseClass' => 'GetDetectDocumentResultOutput',
            'responseType' => 'model',
            'parameters' => array(
                'Bucket' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
                'Key' => array(
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ),
            ),
        );
    }
    public static function GetDetectDocumentResultOutput() {
        return array(
            'type' => 'object',
            'additionalProperties' => true,
            'properties' => array(
                'Body' => array(
                    'type' => 'string',
                    'instanceOf' => 'GuzzleHttp\\Psr7\\Stream',
                    'location' => 'body',
                ),
                'RequestId' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'x-ci-request-id',
                ),
                'ContentType' => array(
                    'type' => 'string',
                    'location' => 'header',
                    'sentAs' => 'Content-Type',
                ),
                'ContentLength' => array(
                    'type' => 'numeric',
                    'minimum'=> 0,
                    'location' => 'header',
                    'sentAs' => 'Content-Length',
                ),
            ),
        );
    }
}