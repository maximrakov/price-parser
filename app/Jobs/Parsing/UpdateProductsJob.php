<?php

namespace App\Jobs\Parsing;

use App\Jobs\ExecuteParsingJob;
use App\Jobs\Parsing\Api\ApiParsingJob;
use App\Jobs\Parsing\Dom\ParseProductPageJob;
use App\Models\Product;
use App\Models\Shop;
use App\Parser\Api\Mvideo\MvideoParser;
use App\Parser\Dom\Strategy\Catalog\ParseCatalogPageManager;
use App\Parser\RegardProductParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->updateDOMProduct();
        $this->updateByAPI();
    }

    private function updateDOMProduct()
    {
        Product::cursor()->each(function($product) {
            if ($product->parsingWay === 'dom') {
                $link = $product->link;
                dispatch(new ParseProductPageJob($link, ParseCatalogPageManager::getStrategy($link)))->onQueue('updatingQueue');
            }
        });
    }

    private function updateByAPI()
    {
        Shop::cursor()->each(
            function ($shop) {
                if ($shop->parsingWay == 'api') {
                    dispatch(new ExecuteParsingJob(new $shop->parser))->onQueue('updatingQueue');
                }
            }
        );
    }
}
