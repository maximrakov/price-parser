<?php

namespace App\Parser;

class CustomCurl
{
    private $httpHeaders = [];

    private $requestMethod = 'GET';
    private $cookie;
    private $postFields = null;

    public function putHeader($key, $value)
    {
        $this->httpHeaders[$key] = $value;
    }

    public function setPostFields($postFields)
    {
        $this->postFields = $postFields;
    }

    public function setRequstMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    public function transformHeadersArray()
    {
        $transformedHeaders = [];
        foreach ($this->httpHeaders as $key => $value) {
            $transformedHeaders[] = "$key: $value";
        }
        return $transformedHeaders;
    }

    private function makeCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->requestMethod);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->transformHeadersArray($this->httpHeaders));
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        if ($this->postFields) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postFields);
        }
        return $ch;
    }

    public function parse($url)
    {
        $ch = $this->makeCurl($url);
        $response = curl_exec($ch);
        mb_detect_encoding($response, 'UTF-8,ISO-8859-15');
        $this->postFields = null;
        return $response;
    }
}
