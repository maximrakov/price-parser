<?php

namespace App\Parser\Dom;

use App\Jobs\ParseCatalogPageJob;
use App\Parser\CustomCurl;
use DOMWrap\Document;

abstract class CatalogParser
{
    protected $curl;

    public function __construct()
    {
        $curl = new CustomCurl();
    }
    protected $currentPageNumber = 0;
    protected $catalogNumber = 0;

    protected function getCurrentPageUrl()
    {
        $this->currentPageNumber++;
        return $this->getCatalogStartPages()[$this->catalogNumber] . $this->currentPageNumber;
    }

    abstract function getCatalogStartPages();

    public function crawlingPages()
    {
        $startPage = CustomCurl::parse($this->getCatalogStartPages()[0]);
        $dom = new Document();
        $dom->html($startPage);
        $pageAmount = $this->getPageAmount($dom);
        for (; $this->catalogNumber < count($this->getCatalogStartPages()); $this->catalogNumber++) {
            for ($i = 0; $i < $pageAmount; $i++) {
                $url = $this->getCurrentPageUrl();
                dispatch(new ParseCatalogPageJob($url));
            }
            $this->currentPageNumber = 0;
        }
    }

    private function getPageAmount($dom)
    {
        $pageNumbers = $dom->find($this->getBlockWithPageNumber());
        $pageNumbers = $pageNumbers->each(function ($node) {
        });
        return $pageNumbers[count($pageNumbers) - 1]->text();
    }
}
