<?php

namespace App\Bot;

use App\Models\User;
use Telegram\Bot\Api;

class TelegramBot
{
    protected $telegram;
    public static $updateId;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $updates = $this->telegram->getUpdates();
        if (!empty($updates)) {
            static::$updateId = $updates[0]['update_id'] + 1;
        }
    }

    public function listenUser()
    {
        for ($i = 0; $i < 3; $i++) {
            $timeout = 60;
            $updates = $this->telegram->getUpdates(['offset' => static::$updateId, 'timeout' => $timeout]);
            $chatId = intval($updates[0]['message']['chat']['id']);
            $code = $updates[0]['message']['text'];
            $user = User::where('code', $code)->first();
            print_r(static::$updateId);
            static::$updateId = $updates[0]['update_id'] + 1;
            print_r(static::$updateId);
            if (!$user) {
                $this->telegram->sendMessage(['chat_id' => $chatId, 'text' => 'Verification code is not correct']);
            } else {
                $user->chatId = $chatId;
                $user->save();
                $this->telegram->sendMessage(['chat_id' => $chatId, 'text' => "You have been successfully registered"]);
                return;
            }
        }
    }
}
