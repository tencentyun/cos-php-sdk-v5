<?php

namespace Qcloud\Cos;

/**
 * 为 src/Qcloud/Cos/Service.php 服务，视觉上区分各方法的参数\输出描述
 * 原service的参数描述可不改动
 * Class Descriptions
 * @package Qcloud\Cos
 */
class Descriptions {
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
}