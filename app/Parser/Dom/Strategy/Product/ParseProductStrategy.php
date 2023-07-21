<?php

namespace App\Parser\Dom\Strategy\Product;

use App\DTO\ProductDTO;
use App\Events\PriceUpdated;
use App\Models\Product;
use App\Parser\CustomCurl;
use App\Parser\Dom\DomParserTrait;
use App\Parser\UrlTrait;
use App\Services\ProductService;
use DOMWrap\Document;
use Illuminate\Support\Facades\Http;

abstract class ParseProductStrategy
{
    use DomParserTrait, UrlTrait;

    private $link;
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    abstract function getPriceBlockCssSelector();

    abstract function getNameBlockCssSelector();

    abstract function getImageBlockCssSelector();

    abstract function getHost();

    public function parse($link): void
    {
        $dom = $this->getPageDOM($link);
        $price = $this->getPrice($dom);
        $name = $this->getName($dom);
        $image = $this->getImage($dom);
        $this->productService->save(new ProductDTO($link, $name, $price, $image, 'dom'));
    }

    protected function parsePrice($price): int
    {
        $price = str_replace('₽', '', $price);
        $nbsp = html_entity_decode("&nbsp;");
        $price = str_replace($nbsp, '', $price);
        return intval($price);
    }

    private function getPrice($dom): int
    {
        return $this->parsePrice($dom->find($this->getPriceBlockCssSelector())->text());
    }

    private function getName($dom): string
    {
        return $dom->find($this->getNameBlockCssSelector())->text();
    }

    private function getImage($dom): string
    {
        $relativeImageLink = $dom->find($this->getImageBlockCssSelector())->attr('src');
        return $this->getFullNormalizedUrl($this->getHost(), $relativeImageLink);
    }
}
