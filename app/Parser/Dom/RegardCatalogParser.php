<?php

namespace App\Parser\Dom;

use App\Parser\Dom\Strategy\Product\RegardParseProductStrategy;

class RegardCatalogParser extends CatalogParser
{
    protected $catalogStartPages = [
        'https://www.regard.ru/catalog/new?page=',
        'https://www.regard.ru/catalog/1015/nakopiteli-ssd?page=',
        'https://www.regard.ru/catalog/1127/noutbuki?page='
    ];

    function getLinkBlockCssSelector()
    {
        return '.CardText_link__C_fPZ';
    }

    function getBlockWithPageNumber()
    {
        return '.Pagination_item__link__vQTps';
    }
}
