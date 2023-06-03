<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function subscribeProduct(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request['id']);
        $product->users()
            ->save($user);
    }

    public function unsubscribeProduct(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request['id']);
        $product->users()
            ->detach($user);
    }

    public function hasProduct(Request $request)
    {
        return Auth::user()
                ->products()
                ->find($request['id']) !== null;
    }
}
