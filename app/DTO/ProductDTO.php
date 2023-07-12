<?php

namespace App\DTO;

class ProductDTO
{
    public $link;
    public $name;
    public $price;
    public $image;

    public function __construct($link, $name, $price, $image)
    {
        $this->name = $name;
        $this->link = $link;
        $this->price = $price;
        $this->image = $image;
    }
}
