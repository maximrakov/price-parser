<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Session;
use Telegram\Bot\Api;

class TelegramRepository
{
    private $broker;

    public function __construct()
    {
        $this->broker = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function getFirstUnreadMessage()
    {
        $messageInfo = $this->broker->getUpdates(['timeout' => 60, 'limit' => 1]);
        $this->markMessageAsRead($messageInfo);
        return [
            'chatId' => intval($messageInfo[0]['message']['chat']['id']),
            'confirmCode' => $messageInfo[0]['message']['text'],
        ];
    }

    private function markMessageAsRead($messageInfo)
    {
        $this->broker->getUpdates(['update_id' => $messageInfo[0]['update_id'] + 1]);
    }
}
