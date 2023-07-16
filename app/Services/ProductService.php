<?php

namespace App\Services;

use App\Events\PriceUpdated;
use App\Models\Product;

class ProductService
{
    public function save($productDTO): void
    {
        $product = Product::where('link', $productDTO->link)->first();
        if ($product == null) {
            $this->persistProduct($productDTO);
        } else {
            if ($product->price != $productDTO->price) {
                $this->updatePrice($product, $productDTO->price);
            }
        }
    }

    private function persistProduct($productDTO): void
    {
        $product = new Product(['link' => $productDTO->link,
            'name' => $productDTO->name,
            'price' => $productDTO->price,
            'image' => $productDTO->image,
            'shop_name' => $this->getShopNameByLink($productDTO->link),
            'parsing_way' => $productDTO->parsingWay
        ]);
        $product->save();
        $this->pushPrice($product, $productDTO->price);
        $product->save();
    }

    private function updatePrice($product, $price): void
    {
        $product->price = $price;
        event(new PriceUpdated($product));
        $this->pushPrice($product, $price);
    }

    private function pushPrice($product, $price): void
    {
        $product->priceEntry()->create(['price' => $price, 'time' => date('Y-m-d H:i:s')]);
    }

    private function getShopNameByLink($link)
    {
        $subDomains = $this->subDomainsOfNormalizedUrl($link);
        return ($subDomains)[count($subDomains) - 2];
    }

    private function subDomainsOfNormalizedUrl($link)
    {
        return explode('.', $this->normalizeUrl($link));
    }

    private function normalizeUrl($link)
    {
        return parse_url($link, PHP_URL_HOST);
    }
}
