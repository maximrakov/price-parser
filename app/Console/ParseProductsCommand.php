<?php

namespace App\Console;

use App\Jobs\ParseProductsJob;
use Illuminate\Console\Command;

class ParseProductsCommand extends Command
{
    protected $signature = 'parse:products';
    protected $description = 'Parse products data';
    public function handle()
    {
        dispatch(new ParseProductsJob());
    }
}
