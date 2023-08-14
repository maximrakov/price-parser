<?php

namespace App\Parser\Dom;

use DOMWrap\Document;
use Illuminate\Support\Facades\Http;

trait DomParserTrait
{
    public function getPageDOM($url): Document
    {
        $page = $this->getPage($url);
        $dom = new Document();
        $dom->html($page);
        return $dom;
    }

    private function getPage($url): string
    {
        return Http::retry(5, 10000)->withHeaders(['user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36'])
            ->get($url)->body();
    }
}
