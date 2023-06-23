<?php

namespace App\Parser\Strategy\Catalog;

use App\Jobs\ParseCatalogPageJob;
use App\Jobs\ParseProductPageJob;
use App\Parser\ParserTools;
use DOMWrap\Document;

abstract class ParseCatalogPageStrategy
{
    abstract function getLinkBlockCssSelector();

    abstract function getHost();

    public function handle($url)
    {
        $page = ParserTools::parse($url);
        $dom = new Document();
        $dom->html($page);
        $links = $dom->find($this->getLinkBlockCssSelector());
        $linksList = $links->each(function ($node) {
        });
        for ($i = 0; $i < count($linksList); $i++) {
            $link = $linksList[$i]->attr('href');
            dispatch(new ParseProductPageJob($this->getHost() . $link));
        }
    }
}
