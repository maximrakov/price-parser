<?php

namespace App\Parser;

use App\Models\Product;
use DOMDocument;
use DOMWrap\Document;
use Rct567\DomQuery\DomQuery;

abstract class CatalogParser
{
    protected $currentPageNumber = 0;
    protected $havePages = true;

    protected function getCurrentPageUrl()
    {
        $this->currentPageNumber++;
        return $this->getFirstPage() . $this->currentPageNumber;
    }

    abstract function getPriceBlockCssSelector();

    abstract function getNameBlockCssSelector();

    abstract function getFirstPage();

    protected function retrieveCurrentPage()
    {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $this->getCurrentPageUrl());
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            'authority: www.regard.ru',
//            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
//            'accept-language: en-US,en;q=0.8,ru;q=0.9',
//            'cache-control: max-age=0',
//            'sec-ch-ua: "Google Chrome";v="111", "Not(A:Brand";v="8", "Chromium";v="111"',
//            'sec-ch-ua-mobile: ?0',
//            'sec-ch-ua-platform: "Linux"',
//            'sec-fetch-dest: document',
//            'sec-fetch-mode: navigate',
//            'sec-fetch-site: same-origin',
//            'sec-fetch-user: ?1',
//            'upgrade-insecure-requests: 1',
//            'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
//            'accept-encoding: gzip',
//        ]);
//        curl_setopt($ch, CURLOPT_COOKIE, 'site_laravel_session=zVEgl2nfhthvK92tEe9me3k659TrSMbCqoJk8rL7; _ga=GA1.1.2030128009.1685536471; _ym_uid=1685536472310248048; _ym_d=1685536472; _ym_isad=1; screen_size=815; _ga_Y5HBMNKL3C=GS1.1.1685536471.1.1.1685536649.0.0.0; city_id=248');
//        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
//
//        $response = curl_exec($ch);
//        mb_detect_encoding($response, 'UTF-8,ISO-8859-15');
//        curl_close($ch);
//        return $response;
        return file_get_contents('/home/maximrakov/repos/work/price-parser/resources/aba.html');
    }

    protected function parsePrice($price)
    {
        $price = str_replace('₽', '', $price);
        $nbsp = html_entity_decode("&nbsp;");
        $price = str_replace($nbsp, '', $price);
        return intval($price);
    }

    protected function parsePage($page)
    {
        $doc = new Document();
        $doc->html($page);
        $prices = $doc->find($this->getPriceBlockCssSelector());
        $names = $doc->find($this->getNameBlockCssSelector());
        $namesList = $names->each(function ($node) {
        });
        $pricesList = $prices->each(function ($node) {
        });
        if (count($namesList) == 0) {
            $this->havePages = false;
            return;
        }
        for ($i = 0; $i < count($namesList); $i++) {
            $link = $namesList[$i]->attr('href');
            $name = $namesList[$i]->text();
            $price = $this->parsePrice($pricesList[$i]->text());
            $this->persistProduct($link, $name, $price);
        }
    }

    protected function persistProduct($link, $name, $price)
    {
        $product = Product::where('link', $link)->first();
        if ($product == null) {
            $product = new Product(['link' => $link, 'name' => $name, 'price' => $price]);
            $product->save();
            $product->priceEntry()->create(['price' => $price, 'time' => date('Y-m-d H:i:s')]);
        } else {
            if ($product->price != $price) {
                $product->price = $price;
                $product->priceEntry()->create(['price' => $price, 'time' => date('Y-m-d H:i:s')]);
            }
        }
    }

    public function crawlingPages()
    {
        while ($this->havePages) {
            $this->parsePage($this->retrieveCurrentPage());
        }
    }
}
