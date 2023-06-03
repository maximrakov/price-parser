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
        $product = Product::where('link', $request['link'])->first();
        return Inertia::render('Product',
            ['product' => $product, 'priceHistory' => $product->priceEntry()->get()]);
    }
}
