<?php

namespace App\Parser\Strategy\Catalog;

use App\Parser\Strategy\Product\RegardParseProductStrategy;

class RegardParseCatalogPageStrategy extends ParseCatalogPageStrategy
{
    private $catalogStartPages = ['https://www.regard.ru/catalog/new?page=',
        'https://www.regard.ru/catalog/1015/nakopiteli-ssd?page=',
        'https://www.regard.ru/catalog/1127/noutbuki?page='
    ];

    function getLinkBlockCssSelector()
    {
        return '.CardText_link__C_fPZ';
    }

    function getCatalogStartPages()
    {
        return $this->catalogStartPages;
    }

    function getProductClass()
    {
        return RegardParseProductStrategy::class;
    }

    public function getHost()
    {
        return 'https://www.regard.ru';
    }
}
