<?php

namespace App\Parser;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Http;

class CookieService
{
    public function get($url)
    {
        $cookies = new CookieJar();
        while (true) {
            $response = Http::withHeaders(['user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'])
                ->withOptions(['cookies' => $cookies])
                ->get($url);
            $cookies = $response->cookies();
            if ($response->ok()) {
                return $cookies;
            }
            sleep(1);
        }
    }
}
