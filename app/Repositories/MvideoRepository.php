<?php

namespace App\Repositories;

use App\Parser\CookieRepository;
use Illuminate\Support\Facades\Http;

class MvideoRepository
{
    private $cookieRepository;

    private $host = 'https://www.mvideo.ru/';
    private $userAgent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36';

    private $contentType = 'application/json';

    public function __construct()
    {
        $this->cookieRepository = new CookieRepository();
    }

    public function getResponse($method, $url, $referer, $body = null)
    {
        $headers = ['user-agent' => $this->userAgent];
        $request = Http::withOptions(['cookies' => $this->cookieRepository->get($this->host)]);
        if ($body) {
            $headers['content-type'] = $this->contentType;
            $headers['origin'] = $this->host;
            $headers['referer'] = $referer;
            return $request
                ->withHeaders($headers)
                ->$method($url, $body)
                ->body();
        }
        return $request
            ->withHeaders($headers)
            ->$method($url)
            ->body();
    }
}
