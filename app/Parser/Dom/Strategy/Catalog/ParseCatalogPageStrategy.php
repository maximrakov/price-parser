<?php

namespace App\Parser\Dom\Strategy\Catalog;

use App\Jobs\Parsing\Dom\ParseProductPageJob;
use App\Parser\CustomCurl;
use App\Parser\Dom\DomParserTrait;
use App\Parser\UrlTrait;

abstract class ParseCatalogPageStrategy
{
    use DomParserTrait, UrlTrait;

    abstract function getLinkBlockCssSelector();

    abstract function getHost();

    abstract function getParseProductPageStrategy();

    abstract static function apply($url);

    public function handle($url): void
    {
        $dom = $this->getPageDOM($url);
        $linkBlocks = $this->getLinkBlocks($dom);
        $linkBlocks->each(function ($linkBlock) {
            $link = $linkBlock->attr('href');
            dispatch(new ParseProductPageJob($this->getFullNormalizedUrl($this->getHost(), $link), $this->getParseProductPageStrategy()))->onQueue('parsingQueue');
        });
    }

    private function getLinkBlocks($dom)
    {
        return $dom->find($this->getLinkBlockCssSelector());
    }
}
