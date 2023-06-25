<?php

namespace App\Jobs;

use App\Parser\ParserTools;
use App\Parser\Strategy\Catalog\ParseCatalogPageStrategy;
use App\Parser\Strategy\Catalog\RegardParseCatalogPageStrategy;
use DOMWrap\Document;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        $parseCatalogPageStrategy = $this->getParseCatalogPageStrategyByUrl();
        $parseCatalogPageStrategy->handle($this->url);
    }
    public function getParseCatalogPageStrategyByUrl() {
        if(str_contains($this->url, 'regard')) {
            return new RegardParseCatalogPageStrategy();
        }
    }
}
