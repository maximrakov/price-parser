<?php

namespace App\Jobs\Parsing;

use App\Jobs\Parsing\Api\ApiParsingJob;
use App\Jobs\Parsing\Dom\DomParsingJob;
use App\Parser\Api\Mvideo\MvideoParser;
use App\Parser\Dom\RegardCatalogParser;
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
        $this->runApiJob(new MvideoParser());
        $this->runDomJob(new RegardCatalogParser());
    }

    private function runApiJob($parser)
    {
        dispatch(new ApiParsingJob($parser))->onQueue('parsingQueue');
    }

    private function runDomJob($parser)
    {
        dispatch(new DomParsingJob($parser))->onQueue('parsingQueue');
    }
}
