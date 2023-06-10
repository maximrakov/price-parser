<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Parser\RegardProductParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = Product::all();
        foreach ($products as $product) {
            $link = $product->link;
            $this->getParser($link)->parse($link);
        }
    }

    public function getParser($link)
    {
        if (str_contains($link, 'regard')) {
            return new RegardProductParser();
        }
    }
}
