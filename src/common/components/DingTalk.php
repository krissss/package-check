<?php

namespace common\components;

use common\exceptions\ApiResponseErrorException;
use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * Class DingTalk
 * @link https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.OjyRTF&treeId=257&articleId=105735&docType=1
 */
class DingTalk extends BaseObject
{
    /**
     * @var string
     */
    public $webhook;

    /**
     * @var Client
     */
    private $_client;

    public function init()
    {
        $this->_client = new Client([
            'baseUrl' => $this->webhook,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
    }

    /**
     * @param array $data
     * @param string $method
     * @return array
     * @throws ApiResponseErrorException
     */
    protected function api($data = [], $method = 'POST')
    {
        /** @var Response $response */
        $response = $this->_client->createRequest()
            ->setMethod($method)
            ->setData($data)
            ->addHeaders(['content-type' => 'application/json', 'charset' => 'utf-8'])
            ->send();
        if ($response->isOk) {
            $result = json_decode($response->content, true);
            if ($result['errmsg'] == 'ok') {
                return $result;
            } else {
                throw new ApiResponseErrorException($response->content);
            }
        } else {
            if ($response->statusCode == 404) {
                return [];
            }
        }
        throw new ApiResponseErrorException($response->statusCode);
    }

    /**
     * 文本类型
     *
     * @param string $content
     * @param array|string $atMobiles
     * @param bool $isAtAll
     * @throws ApiResponseErrorException
     */
    public function sendText($content, $atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ],
            'at' => [
                'atMobiles' => (array)$atMobiles,
                'isAtAll' => (bool)$isAtAll
            ],
        ];
        $this->api($data);
    }

    /**
     * link类型
     *
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param null|string $picUrl
     * @throws ApiResponseErrorException
     */
    public function sendLink($title, $text, $messageUrl, $picUrl = null)
    {
        $data = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'messageUrl' => $messageUrl,
                'picUrl' => $picUrl
            ],
        ];
        $this->api($data);
    }

    /**
     * markdown类型
     *
     * @param string $title
     * @param string $text
     * @param array|string $atMobiles
     * @param bool $isAtAll
     * @throws ApiResponseErrorException
     */
    public function sendMarkdown($title, $text, $atMobiles = [], $isAtAll = false)
    {
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $text,
            ],
            'at' => [
                'atMobiles' => (array)$atMobiles,
                'isAtAll' => (bool)$isAtAll
            ],
        ];
        $this->api($data);
    }

    /**
     * 整体跳转ActionCard类型
     *
     * @param string $title
     * @param string $text
     * @param string $singleURL
     * @param string $singleTitle
     * @param bool $btnOrientation
     * @param bool $hideAvatar
     * @throws ApiResponseErrorException
     */
    public function sendActionCardSingle($title, $text, $singleURL, $singleTitle = '阅读全文', $btnOrientation = false, $hideAvatar = false)
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL,
                'btnOrientation' => (int)(bool)$btnOrientation,
                'hideAvatar' => (int)(bool)$hideAvatar,
            ],
        ];
        $this->api($data);
    }

    /**
     * 独立跳转ActionCard类型
     *
     * @param string $title
     * @param string $text
     * @param array $btns [['title' => 'xxx', 'actionURL' => 'xxx']]
     * @param bool $btnOrientation
     * @param bool $hideAvatar
     * @throws ApiResponseErrorException
     */
    public function sendActionCardMulti($title, $text, $btns = [], $btnOrientation = false, $hideAvatar = false)
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btns' => $btns,
                'btnOrientation' => (int)(bool)$btnOrientation,
                'hideAvatar' => (int)(bool)$hideAvatar,
            ],
        ];
        $this->api($data);
    }

    /**
     * FeedCard类型
     *
     * @param array $links [['title' => 'xxx', 'messageURL' => 'xxx', 'picURL' => 'xxx']]
     * @throws ApiResponseErrorException
     */
    public function sendFeedCard($links = [])
    {
        $data = [
            'msgtype' => 'feedCard',
            'feedCard' => [
                'links' => $links,
            ],
        ];
        $this->api($data);
    }
}
