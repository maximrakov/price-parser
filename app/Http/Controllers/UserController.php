<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductUserRequest;
use App\Http\Requests\DeleteProductUserRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProduct($userId, $productId)
    {
        $user = User::findOrFail($userId);
        $product = $user->products()
            ->withPivot('notification_price')
            ->findOrFail($productId);
        return $product;
    }

    public function addProduct($userId, $productId, CreateProductUserRequest $request)
    {
        $notificationPrice = $request['notificationPrice'];
        $user = User::findOrFail($userId);
        $product = Product::findOrFail($productId);
        $user->products()->attach($productId, ['notification_price' => $notificationPrice]);
    }

    public function deleteProduct($userId, $productId, DeleteProductUserRequest $request)
    {
        $user = User::findOrFail($userId);
        $user->products()->detach($productId);
    }
}
