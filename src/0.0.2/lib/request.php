<?php

namespace Imyie\Dadata;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Request
{

    public $data = [];
    public $response = '';

    /**
     * Request constructor.
     * @param string $url
     * @throws \Exception
     */
    public function __construct(string $url)
    {
        if (empty($url)) {
            throw new \Exception(Loc::getMessage('IMTIE_LIB_REQUEST_EXCEPTION_EMPTY_URL'));
        }

        $token = Option::get('imyie.dadata', 'token', '');
        if (empty($token)) {
            throw new \Exception(Loc::getMessage('IMTIE_LIB_REQUEST_EXCEPTION_EMPTY_TOKEN'));
        }
        $token = 'Token ' . $token;

        $this->httpClient = new HttpClient();

        $this->httpClient->setHeader('Content-Type', 'application/json');
        $this->httpClient->setHeader('Accept', 'application/json');
        $this->httpClient->setHeader('Authorization', $token);

        $this->url = $url;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getData4Post(): bool|string
    {
        return json_encode($this->getData());
    }

    public function getData4Get(): string
    {
        return http_build_query($this->getData());
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function post(): void
    {
        $this->response = $this->httpClient->post($this->getUrl(), $this->getData4Post());
    }

    public function get(): void
    {
        $this->response = $this->httpClient->get($this->getUrl() . '?' . $this->getData4Get());
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getResponseArray()
    {
        return json_decode($this->getResponse(), true);
    }

}
