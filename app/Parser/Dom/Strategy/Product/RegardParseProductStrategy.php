<?php

namespace App\Parser\Dom\Strategy\Product;

class RegardParseProductStrategy extends ParseProductStrategy
{
    public function __construct()
    {
        parent::__construct();
        $this->curl->putHeader('authority', 'www.regard.ru');
        $this->curl->putHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36');
    }

    function getPriceBlockCssSelector()
    {
        return '.PriceBlock_price__j_PbO .Price_price__m2aSe';
    }

    function getNameBlockCssSelector()
    {
        return '.productPage_title__GOGLp';
    }

    function getImageBlockCssSelector()
    {
        return '.BigSlider_slide__image__2qjPm';
    }

    public function getHost()
    {
        return 'https://www.regard.ru';
    }
}
