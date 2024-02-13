<?php

namespace App\Parser\Dom;

use App\Parser\ShopParser;

class RegardParser implements ShopParser
{

    function run($update = false)
    {
        $regardParser = new RegardCatalogParser();
        $regardParser->parse();
    }
}
