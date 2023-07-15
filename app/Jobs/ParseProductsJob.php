<?php

namespace App\Jobs;

use App\Parser\Api\MvideoCatalogParser;
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
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $parser = new MvideoCatalogParser('https://www.mvideo.ru/noutbuki-planshety-komputery-8/noutbuki-118', 118);
        $parser->parse('https://www.mvideo.ru/noutbuki-planshety-komputery-8/noutbuki-118');
    }
}
