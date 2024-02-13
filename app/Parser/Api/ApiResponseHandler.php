<?php

namespace App\Parser\Api;

class ApiResponseHandler
{
    public function handle($response, $path)
    {
        $json = json_decode($response);
        $path = explode('.', $path);
        foreach ($path as $elem) {
            $json = $json->$elem;
        }
        return $json;
    }
}
