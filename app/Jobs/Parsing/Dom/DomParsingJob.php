<?php

namespace App\Jobs\Parsing\Dom;

use App\Parser\Dom\CatalogParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DomParsingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private CatalogParser $parser;

    public function __construct(CatalogParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->parser->crawlingPages();
    }
}
