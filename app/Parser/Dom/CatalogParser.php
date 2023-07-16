<?php

namespace App\Parser\Dom;

use App\Parser\CustomCurl;
use App\Parser\Dom\Strategy\Catalog\ParseCatalogPageManager;

abstract class CatalogParser
{
    use DomParserTrait;

    private $manager;

    public function __construct()
    {
        $this->manager = new ParseCatalogPageManager();
    }

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
            $url = $this->getCatalogPageUrl($catalogStartPageUrl, $pageNumber);
            $strategy = $this->manager->getStrategy($url);
            $strategy->handle($url);
        }
    }

    private function getCatalogPageUrl($catalogStartPageUrl, $pageNumber): string
    {
        return $catalogStartPageUrl . $pageNumber;
    }

    private function getPageAmount($url)
    {
        $dom = $this->getPageDOM($url);
        return intval($dom->find($this->getBlockWithPageNumber())->last()->text());
    }
}
