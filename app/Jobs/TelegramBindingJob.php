<?php

namespace App\Jobs;

use App\Models\User;
use App\Repositories\TelegramRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Telegram\Bot\Api;

class TelegramBindingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $telegram;
    protected $telegramRepository;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $this->telegramRepository = new TelegramRepository();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $message = $this->telegramRepository->getFirstUnreadMessage();
            $user = User::where('code', $message['confirmCode'])->first();
            $chatId = $message['chatId'];
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
