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
        $product = Product::create(['link' => $productDTO->link, 'name' => $productDTO->name, 'price' => $productDTO->price, 'image' => $productDTO->image]);
        $this->pushPrice($product, $productDTO->price);
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
}
