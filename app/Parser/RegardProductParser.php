<?php

namespace App\Parser;

class RegardProductParser extends ProductParser
{
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

    public function getHost() {
        return 'https://www.regard.ru';
    }
}
