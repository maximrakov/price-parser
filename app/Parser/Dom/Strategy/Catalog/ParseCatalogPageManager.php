<?php

namespace App\Parser\Dom\Strategy\Catalog;

class ParseCatalogPageManager
{
    private static $strategies = [RegardParseCatalogPageStrategy::class];

    public static function getStrategy($url)
    {
        foreach (self::$strategies as $strategy) {
            if ((new $strategy)::apply($url)) {
                return $strategy;
            }
        }
    }
}
