<?php

namespace common\components;

use common\exceptions\ApiResponseErrorException;
use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\httpclient\Response;

class Packagist extends BaseObject
{
    public $baseUrl = 'https://packagist.org';

    /**
     * @var Client
     */
    private $_client;

    public function init()
    {
        $this->_client = new Client([
            'baseUrl' => $this->baseUrl,
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
    }

    /**
     * @param $url
     * @param array $data
     * @param string $method
     * @return array
     * @throws ApiResponseErrorException
     */
    protected function api($url, $data = [], $method = 'GET')
    {
        /** @var Response $response */
        $response = $this->_client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->send();
        if ($response->isOk) {
            return json_decode($response->content, true);
        } else {
            if ($response->statusCode == 404) {
                return [];
            }
        }
        throw new ApiResponseErrorException($response->statusCode);
    }

    /**
     * @link https://packagist.org/apidoc#get-package-by-name
     *
     * @param $vendor
     * @param $package
     * @return array
     */
    public function getPackageByName($vendor, $package)
    {
        $result = $this->api("packages/{$vendor}/{$package}.json");
        return $result ? $result['package'] : [];
    }
}
