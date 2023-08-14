<?php

namespace App\Jobs\Parsing\Dom;

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
    private $strategy;

    public function __construct($url, $strategy)
    {
        $this->url = $url;
        $this->strategy = $strategy;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(3);
        (new $this->strategy)->parse($this->url);
    }
}
