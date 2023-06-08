<?php

namespace App\Parser;

class RegardCatalogParser extends CatalogParser
{
    function getLinkBlockCssSelector()
    {
        return '.CardText_link__C_fPZ';
    }

    function getFirstPage()
    {
        return 'https://www.regard.ru/catalog/new?page=';
    }

    public function getHost()
    {
        return 'https://www.regard.ru';
    }
}
