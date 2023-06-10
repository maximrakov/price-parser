<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProduct($userId, $productId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response("user not found", 404);
        }
        $product = $user->products()
            ->withPivot('notification_price')
            ->find($productId);

        if (!$product) {
            return response("product not found", 404);
        }
        return $product;
    }

    public function addProduct($userId, $productId, Request $request)
    {
        $notificationPrice = $request['notificationPrice'];
        return $this->product('attach', $userId, $productId, $notificationPrice);
    }

    public function deleteProduct($userId, $productId)
    {
        return $this->product('detach', $userId, $productId);
    }

    private function product($action, $userId, $productId, $notificationPrice = null)
    {
        $user = User::find($userId);
        $product = Product::find($productId);
        if (!$user || !$product) {
            $notFoundResourse = (!$user and !$product) ? 'user and product' : (!$user ? 'user' : 'product');
            return response("$notFoundResourse not found", 404);
        }
        $userHasProduct = ($user->products()->find($productId) !== null) && ($action === 'save');
        $userHasNotProduct = ($user->products()->find($productId) === null) && ($action === 'detach');
        if ($userHasProduct || $userHasNotProduct) {
            return response('conflict', 409);
        }
        if ($notificationPrice) {
            return $user->products()->$action($productId, ['notification_price' => $notificationPrice]);
        } else {
            return $user->products()->$action($productId);
        }
    }
}
