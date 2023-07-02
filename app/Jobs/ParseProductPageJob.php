<?php

namespace App\Jobs;

use App\Parser\Dom\Strategy\Product\RegardParseProductStrategy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseProductPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(3);
        $this->getParser()
            ->parse($this->url);
    }

    public function getParser()
    {
        if (str_contains($this->url, 'regard')) {
            return new RegardParseProductStrategy();
        }
    }
}
