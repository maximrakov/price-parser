<?php

namespace App\Parser\Strategy\Product;

use App\Events\PriceUpdated;
use App\Models\Product;
use App\Parser\ParserTools;
use DOMWrap\Document;

abstract class ParseProductStrategy
{
    private $link;

    abstract function getPriceBlockCssSelector();

    abstract function getNameBlockCssSelector();

    abstract function getImageBlockCssSelector();

    abstract function getHost();

    public function parse($link)
    {
        $page = ParserTools::parse($link);
        $dom = new Document();
        $dom->html($page);
        $price = $this->parsePrice($dom->find($this->getPriceBlockCssSelector())->text());
        $name = $dom->find($this->getNameBlockCssSelector())->text();
        $image = $this->getHost() . $dom->find($this->getImageBlockCssSelector())->attr('src');
        $this->persistProduct($link, $name, $price, $image);
    }

    protected function persistProduct($link, $name, $price, $image)
    {
        $product = Product::where('link', $link)->first();
        if ($product == null) {
            $product = new Product(['link' => $link, 'name' => $name, 'price' => $price, 'image' => $image]);
            $product->save();
            $product->priceEntry()->create(['price' => $price, 'time' => date('Y-m-d H:i:s')]);
        } else {
            if ($product->price != $price) {
                $product->price = $price;
                event(new PriceUpdated($product));
                $product->priceEntry()->create(['price' => $price, 'time' => date('Y-m-d H:i:s')]);
            }
        }
    }

    protected function parsePrice($price)
    {
        $price = str_replace('₽', '', $price);
        $nbsp = html_entity_decode("&nbsp;");
        $price = str_replace($nbsp, '', $price);
        return intval($price);
    }
}
