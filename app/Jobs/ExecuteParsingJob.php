<?php

namespace App\Jobs;

use App\Parser\CatalogParser;
use App\Parser\ShopParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExecuteParsingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private ShopParser $parser;

    public function __construct(ShopParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->parser->run();
    }
}
