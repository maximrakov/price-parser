<?php

namespace App\Jobs\Parsing;

use App\Jobs\ExecuteParsingJob;
use App\Models\Shop;
//use App\Parser\Api\Mvideo\MvideoParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private ?Shop $shop;
    public function __construct(string $shop=null)
    {
        if ($shop) {
            $this->shop = Shop::where('name', $shop)->first();
        } else {
            $this->shop = null;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->shop) {
            dispatch(new ExecuteParsingJob(new $this->shop->parser()));
        } else {
            Shop::cursor()->each(function (Shop $shop) {
                dispatch(new ExecuteParsingJob(new $shop->parser()))->onQueue('parsingQueue');
            });
        }
    }
}
