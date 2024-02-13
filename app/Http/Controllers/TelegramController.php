<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use App\Jobs\Telegram\TelegramBindingJob;

class TelegramController extends Controller
{
    public function telegramBinding()
    {
        TelegramBindingJob::dispatch()->onQueue('telegramBindingQueue');
    }
}
