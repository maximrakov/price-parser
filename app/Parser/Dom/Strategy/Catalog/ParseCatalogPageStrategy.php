<?php

namespace App\Parser\Dom\Strategy\Catalog;

use App\Jobs\ParseProductPageJob;
use App\Parser\CustomCurl;
use DOMWrap\Document;
use Illuminate\Support\Facades\Http;

abstract class ParseCatalogPageStrategy
{
    abstract function getLinkBlockCssSelector();

    abstract function getHost();

    abstract function getParseProductPageStrategy();

    abstract static function apply($url);

    public function handle($url)
    {
        $dom = new Document();
        $dom->html($this->getPage($url));
        $linkBlocks = $dom->find($this->getLinkBlockCssSelector());
        $linkBlocks->each(function ($linkBlock) {
            $link = $linkBlock->attr('href');
            dispatch(new ParseProductPageJob($this->getHost() . $link, $this->getParseProductPageStrategy()));
        });
    }

    private function getPage($url)
    {
        return Http::withHeaders(['user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'])
            ->get($url);
    }
}
