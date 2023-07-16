<?php

namespace App\Jobs\Parsing\Api;

use App\Parser\Api\ApiParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApiParsingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ApiParser $parser;

    /**
     * Create a new job instance.
     */
    public function __construct(ApiParser $apiParser)
    {
        $this->parser = $apiParser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->parser->run();
    }
}
