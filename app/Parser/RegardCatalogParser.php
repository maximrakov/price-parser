<?php

namespace App\Parser;

class RegardCatalogParser extends CatalogParser
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

    public function getHost()
    {
        return 'https://www.regard.ru';
    }
}
