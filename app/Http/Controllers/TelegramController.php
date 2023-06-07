<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class TelegramController extends Controller
{
    public function callBot()
    {
        $bot = app()->get(TelegramBot::class);
        $bot->listenUser();
    }
}
