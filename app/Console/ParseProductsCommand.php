<?php

namespace App\Console;

use App\Jobs\Parsing\ParseProductsJob;
use Illuminate\Console\Command;

class ParseProductsCommand extends Command
{
    protected $signature = 'parse:products {shop?}';
    protected $description = 'Parse products data';
    public function handle()
    {
        if($this->argument('shop')) {
            dispatch(new ParseProductsJob($this->argument('shop')));
        } else {
            dispatch(new ParseProductsJob());
        }
    }
}
