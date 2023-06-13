<?php

namespace App\Parser;

use App\Models\Product;
use DOMDocument;
use DOMWrap\Document;
use Rct567\DomQuery\DomQuery;

abstract class CatalogParser
{
    protected $currentPageNumber = 0;
    protected $catalogNumber = 0;
    protected $havePages = true;

    protected function getCurrentPageUrl()
    {
        $this->currentPageNumber++;
        return $this->getCatalogStartPages()[$this->catalogNumber] . $this->currentPageNumber;
    }

    abstract function getCatalogStartPages();

    abstract function getHost();

    protected function retrieveCurrentPage()
    {
        return ParserTools::parse($this->getCurrentPageUrl());
    }

    protected function parsePage($page)
    {
        $dom = new Document();
        $dom->html($page);
        $links = $dom->find($this->getLinkBlockCssSelector());
        $linksList = $links->each(function ($node) {
        });
        if (count($linksList) == 0) {
            $this->havePages = false;
            return;
        }
        for ($i = 0; $i < count($linksList); $i++) {
            $link = $linksList[$i]->attr('href');
            $parser = new RegardProductParser();
            $parser->parse($this->getHost() . $link);
        }
    }

    public function crawlingPages()
    {
        for (; $this->catalogNumber < count($this->getCatalogStartPages()); $this->catalogNumber++) {
            while ($this->havePages) {
                sleep(3);
                $this->parsePage($this->retrieveCurrentPage());
            }
            $this->havePages = true;
            $this->currentPageNumber = 0;
        }
    }
}
