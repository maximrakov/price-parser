<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Parser\RegardProductParser;
use App\Parser\Strategy\Product\RegardParseProductStrategy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        $products = Product::all();
        foreach ($products as $product) {
            $link = $product->link;
            dispatch(new ParseProductPageJob($link));
        }
    }
}
