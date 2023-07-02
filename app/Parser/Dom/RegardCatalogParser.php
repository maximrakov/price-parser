<?php

namespace App\Parser\Dom;

class RegardCatalogParser extends CatalogParser
{
    public function __construct()
    {
        parent::__construct();
        $this->curl->putHeader('authority', 'www.regard.ru');
        $this->curl->putHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36');
    }

    private $catalogStartPages = [
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

    function getCatalogStartPages()
    {
        return $this->catalogStartPages;
    }
}
