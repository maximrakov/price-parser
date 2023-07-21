<?php

namespace App\Parser\Api\Mvideo;

use App\Jobs\Parsing\Api\ApiParsingCatalogJob;
use App\Parser\Api\ApiParser;

class MvideoParser implements ApiParser
{
    public $catalogs = [['https://www.mvideo.ru/televizory-i-cifrovoe-tv-1/televizory-65', 65],
        ['https://www.mvideo.ru/holodilniki-i-morozilniki-2687/holodilniki-i-morozilnye-kamery-159', 159]];

    public function run($update = false)
    {
        foreach ($this->catalogs as $catalog) {
            $catalogParser = new MvideoCatalogParser($catalog[0], $catalog[1]);
            dispatch(new ApiParsingCatalogJob($catalogParser))->onQueue($update ? 'updatingQueue' : 'parsingQueue');
        }
    }
}
