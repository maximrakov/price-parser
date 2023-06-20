<?php

namespace App\Parser;

use App\Jobs\ParseCatalogPageJob;
use App\Models\Product;
use DOMDocument;
use DOMWrap\Document;
use Rct567\DomQuery\DomQuery;

abstract class CatalogParser
{
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
        $startPage = ParserTools::parse($this->getCatalogStartPages()[0]);
        $dom = new Document();
        $dom->html($startPage);
        $pageCount = intval($dom->find($this->getBlockWithPageAmount())->text());
        for (; $this->catalogNumber < count($this->getCatalogStartPages()); $this->catalogNumber++) {
            for ($i = 0; $i < $pageCount; $i++) {
                $url = $this->getCurrentPageUrl();
                dispatch(new ParseCatalogPageJob($url));
            }
            $this->currentPageNumber = 0;
        }
    }
}
