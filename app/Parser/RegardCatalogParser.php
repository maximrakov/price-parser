<?php

namespace App\Parser;

class RegardCatalogParser extends CatalogParser
{
    function getPriceBlockCssSelector()
    {
        return '.Card_content__eWojG .Price_price__m2aSe';
    }

    function getNameBlockCssSelector()
    {
        return '.CardText_link__C_fPZ';
    }

    function getFirstPage()
    {
        return 'https://www.regard.ru/catalog/new?page=';
    }
}
