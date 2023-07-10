<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    private $timestampsAmountOnProductPage = 5;

    public function index()
    {
        return Inertia::render('Home');
    }

    public function register()
    {
        return Inertia::render('Register');
    }

    public function login()
    {
        return Inertia::render('Login');
    }

    public function product(Request $request)
    {
        $product = null;
        if ($request['link']) {
            $product = Product::where('link', $request['link'])->first();
        } else {
            $product = Product::where('id', $request['id'])->first();
        }
        if (!$product) {
            return Inertia::render('Home', ['error' => 'Incorrect link']);
        }
        return Inertia::render('Product',
            ['product' => $product,
                'priceHistory' => $product->priceEntry()
                    ->skip(($request['page'] - 1) * $this->timestampsAmountOnProductPage)
                    ->take($this->timestampsAmountOnProductPage)
                    ->get()]);
    }

    public function subscriptions($page)
    {
        $products = Auth::user()
            ->products()
            ->skip(($page - 1) * $this->timestampsAmountOnProductPage)
            ->take($this->timestampsAmountOnProductPage)
            ->get();
        return Inertia::render('Subscriptions', ['products' => $products]);
    }

    public function notifications()
    {
        return Inertia::render('Notifications');
    }
}
