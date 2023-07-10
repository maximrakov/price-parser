<?php

namespace App\Providers;

use App\Parser\Api\ApiResponseHandler;
use App\Parser\Api\MvideoCatalogParser;
use App\Parser\CookieService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CookieService::class, function ($app) {
            return new CookieService();
        });
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService();
        });
        $this->app->bind(ApiResponseHandler::class, function ($app) {
            return new ApiResponseHandler();
        });
        $this->app->bind(Api::class, function ($app) {
            return new Api(env('TELEGRAM_BOT_TOKEN'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
