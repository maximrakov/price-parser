<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use App\Jobs\TelegramBindingJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class TelegramController extends Controller
{
    public function telegramBinding()
    {
        TelegramBindingJob::dispatch()->onQueue('telegramBindingQueue');
    }
}
