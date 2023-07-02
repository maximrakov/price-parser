<?php

namespace App\Services;

use App\Events\PriceUpdated;
use App\Models\Product;

class ProductService
{
    public function save($link, $name, $price, $image)
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
}
