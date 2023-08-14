<?php

namespace App\Http\Controllers;

use App\Bot\TelegramBot;
use App\Http\Requests\RedirectRequest;
use App\Http\Requests\ShowProductRequest;
use App\Http\Requests\ShowSubscriptionsRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }

    public function register()
    {
        return Inertia::render('Register');
    }

    public function login(RedirectRequest $request)
    {
        $redirect = $request['redirectTo'] ? $request['redirectTo'] : '/';
        return Inertia::render('Login', ['redirectTo' => $redirect]);
    }

    public function product(ShowProductRequest $request)
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
                    ->paginate(config('constants.products.elements_on_page'))
                    ->items()]);
    }

    public function subscriptions(ShowSubscriptionsRequest $request)
    {
        $productsAmount = Auth::user()->products()->count('link');
        $products = Auth::user()
            ->products()
            ->paginate(config('constants.products.elements_on_page'))
            ->items();
        return Inertia::render('Subscriptions', ['products' => $products,
            'pageAmount' => $this->calcPageAmount($productsAmount, config('constants.products.elements_on_page')),
            'elementsOnPage' => config('constants.products.elements_on_page'),
            'currentPage' => $request['page']]);
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
