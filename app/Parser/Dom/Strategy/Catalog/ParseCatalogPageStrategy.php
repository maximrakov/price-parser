<?php

namespace App\Parser\Dom\Strategy\Catalog;

use App\Jobs\ParseProductPageJob;
use App\Parser\CustomCurl;
use DOMWrap\Document;

abstract class ParseCatalogPageStrategy
{
    protected $curl;

    public function __construct()
    {
        $curl = new CustomCurl();
    }

    abstract function getLinkBlockCssSelector();

    abstract function getHost();

    public function handle($url)
    {
        $page = $this->curl->parse($url);
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
