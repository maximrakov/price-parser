<?php

namespace App\Parser\Dom\Strategy\Catalog;

use App\Parser\Dom\Strategy\Product\RegardParseProductStrategy;

class RegardParseCatalogPageStrategy extends ParseCatalogPageStrategy
{
    function getParseProductPageStrategy()
    {
        return new RegardParseProductStrategy();
    }

    function getLinkBlockCssSelector()
    {
        return '.CardText_link__C_fPZ';
    }

    public function getHost()
    {
        return config('constants.host.regard');
    }

    static function apply($url)
    {
        return str_contains($url, 'regard');
    }
}
