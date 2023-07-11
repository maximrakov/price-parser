<?php

namespace App\Parser\Dom;

use App\Jobs\ParseCatalogPageJob;
use App\Parser\CustomCurl;
use DOMWrap\Document;
use Illuminate\Support\Facades\Http;

abstract class CatalogParser
{
    public function getStartPages()
    {
        return collect($this->catalogStartPages);
    }

    public function crawlingPages()
    {
        $this->getStartPages()->each(function ($catalogStartPageUrl) {
            $this->crawleCatalog($catalogStartPageUrl);
        });
    }

    private function getPageAmount($url)
    {
        $page = $this->getPage($url);
        $dom = new Document();
        $dom->html($page);
        return $dom->find($this->getBlockWithPageNumber())->last()->text();
    }

    private function crawleCatalog($catalogStartPageUrl)
    {
        for ($pageNumber = 0; $pageNumber < $this->getPageAmount($catalogStartPageUrl); $pageNumber++) {
            dispatch($catalogStartPageUrl . $pageNumber);
        }
    }

    private function getPage($url)
    {
        return Http::withHeaders(['user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'])
            ->get($url);
    }
}
