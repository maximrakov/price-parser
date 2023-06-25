<?php

namespace App\Parser;

class ParserTools
{
    public static function parse($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authority: www.regard.ru',
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'accept-language: en-US,en;q=0.8,ru;q=0.9',
            'cache-control: max-age=0',
            'sec-ch-ua: "Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Linux"',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: same-origin',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
            'accept-encoding: gzip',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'site_laravel_session=zVEgl2nfhthvK92tEe9me3k659TrSMbCqoJk8rL7; _ga=GA1.1.2030128009.1685536471; _ym_uid=1685536472310248048; _ym_d=1685536472; _ym_isad=1; screen_size=815; _ga_Y5HBMNKL3C=GS1.1.1685536471.1.1.1685536649.0.0.0; city_id=248');
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');

        $response = curl_exec($ch);
        mb_detect_encoding($response, 'UTF-8,ISO-8859-15');
        curl_close($ch);
        return $response;
    }
}
