<?php

namespace App\Listeners;

use App\Bot\TelegramBot;
use App\Events\PriceUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Telegram\Bot\Api;

class PriceUpdatingNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PriceUpdated $event): void
    {
        $bot = app()->get(Api::class);
        $product = $event->product;
        foreach ($product->users()->withPivot('notification_price')->get() as $user) {
            if ($product->price <= $user->pivot->notification_price) {
                $bot->sendMessage(['chat_id' => $user->chatId, 'text' => "$product->name new price is $product->price"]);
            }
        }
    }
}
