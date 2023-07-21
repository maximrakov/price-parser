<?php

namespace App\DTO;

class ProductDTO
{
    public $link;
    public $name;
    public $price;
    public $image;
    public $parsingWay;

    public function __construct($link, $name, $price, $image, $parsingWay)
    {
        $this->name = $name;
        $this->link = $link;
        $this->price = $price;
        $this->image = $image;
        $this->parsingWay = $parsingWay;
    }
}
