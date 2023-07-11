<?php

namespace App\Parser\Dom\Strategy\Product;

use App\Events\PriceUpdated;
use App\Models\Product;
use App\Parser\CustomCurl;
use App\Services\ProductService;
use DOMWrap\Document;

abstract class ParseProductStrategy
{
    private $link;
    private $productService;
    protected $curl;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    abstract function getPriceBlockCssSelector();

    abstract function getNameBlockCssSelector();

    abstract function getImageBlockCssSelector();

    abstract function getHost();

    public function parse($link)
    {
        $page = $this->curl->parse($link);
        $dom = new Document();
        $dom->html($page);
        $price = $this->parsePrice($dom->find($this->getPriceBlockCssSelector())->text());
        $name = $dom->find($this->getNameBlockCssSelector())->text();
        $image = $this->getHost() . $dom->find($this->getImageBlockCssSelector())->attr('src');
        $this->productService->save($link, $name, $price, $image);
    }

    protected function parsePrice($price)
    {
        $price = str_replace('₽', '', $price);
        $nbsp = html_entity_decode("&nbsp;");
        $price = str_replace($nbsp, '', $price);
        return intval($price);
    }
}
