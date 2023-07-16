<?php

namespace App\Jobs\Parsing\Dom;

use App\Parser\Dom\Strategy\Catalog\ParseCatalogPageManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseCatalogPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $url;
    public $timeout = 120;
    public $failOnTimeout = false;

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
        (new (ParseCatalogPageManager::getStrategy($this->url)))->handle($this->url);
    }
}
