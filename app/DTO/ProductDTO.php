<?php

namespace App\DTO;

class ProductDTO
{
    public function __construct(public string $link, public string $name, public int $price, public string $image, public string $parsingWay, public int $shopId)
    {
    }
}
