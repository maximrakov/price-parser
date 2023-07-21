<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    private $elementsOnPage = 5;

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
                    ->skip(($request['page'] - 1) * $this->elementsOnPage)
                    ->take($this->elementsOnPage)
                    ->get()]);
    }

    public function subscriptions($page)
    {
        $productsAmount = Auth::user()->products()->count('link');
        $products = Auth::user()
            ->products()
            ->skip(($page - 1) * $this->elementsOnPage)
            ->take($this->elementsOnPage)
            ->get();
        return Inertia::render('Subscriptions', ['products' => $products,
            'pageAmount' => $this->calcPageAmount($productsAmount, $this->elementsOnPage),
            'elementsOnPage' => $this->elementsOnPage,
            'currentPage' => $page]);
    }

    public function notifications()
    {
        return Inertia::render('Notifications');
    }

    private function calcPageAmount($productsAmount, $elementsOnPage)
    {
        if ($productsAmount % $elementsOnPage === 0) {
            return intval($productsAmount / $elementsOnPage);
        } else {
            return intval($productsAmount / $elementsOnPage) + 1;
        }
    }
}
