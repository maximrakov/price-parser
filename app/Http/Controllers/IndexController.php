<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Product',
            ['product' => $product, 'priceHistory' => $product->priceEntry()->get()]);
    }

    public function subscriptions()
    {
        $products = Auth::user()->products()->get();
        return Inertia::render('Subscriptions', ['products' => $products]);
    }
}
