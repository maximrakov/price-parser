<?php

namespace App\Jobs\Parsing\Api;

use App\Parser\Api\CatalogParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApiParsingCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CatalogParser $parser;

    /**
     * Create a new job instance.
     */
    public function __construct(CatalogParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->parser->parse();
    }
}
