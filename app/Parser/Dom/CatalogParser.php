<?php

namespace App\Parser\Dom;

use App\Jobs\ParseCatalogPageJob;
use App\Parser\CustomCurl;
use DOMWrap\Document;
use Illuminate\Support\Facades\Http;

abstract class CatalogParser
{
    use DomParserTrait;

    public function getCatalogStartPages(): \Illuminate\Support\Collection
    {
        return collect($this->catalogStartPages);
    }

    public function crawlingPages(): void
    {
        $this->getCatalogStartPages()->each(function ($catalogStartPageUrl) {
            $this->crawleCatalog($catalogStartPageUrl);
        });
    }

    private function crawleCatalog($catalogStartPageUrl): void
    {
        for ($pageNumber = 0; $pageNumber < $this->getPageAmount($catalogStartPageUrl); $pageNumber++) {
            dispatch($this->getCatalogPageUrl($catalogStartPageUrl, $pageNumber))->onQueue('parsingQueue');
        }
    }

    private function getCatalogPageUrl($catalogStartPageUrl, $pageNumber): string
    {
        return $catalogStartPageUrl . $pageNumber;
    }

    private function getPageAmount($url)
    {
        $dom = $this->getPageDOM($url);
        return $dom->find($this->getBlockWithPageNumber())->last()->text();
    }
}
