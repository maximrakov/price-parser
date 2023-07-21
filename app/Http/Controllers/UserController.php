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
        return $this->toggleProductForUser('attach', $userId, $productId, $notificationPrice);
    }

    public function deleteProduct($userId, $productId)
    {
        return $this->toggleProductForUser('detach', $userId, $productId);
    }

    private function toggleProductForUser($action, $userId, $productId, $notificationPrice = null)
    {
        $validated = $this->validateUserAndProduct($userId, $productId);
        $user = $validated['user'];
        if (!$this->validateToggleOperation($user, $productId, $action)) {
            return response('conflict', 409);
        }
        if ($notificationPrice) {
            return $user->products()->$action($productId, ['notification_price' => $notificationPrice]);
        } else {
            return $user->products()->$action($productId);
        }
    }

    private function validateUserAndProduct($userId, $productId): \Illuminate\Foundation\Application|\Illuminate\Http\Response|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = User::find($userId);
        $product = Product::find($productId);
        if (!$user || !$product) {
            $notFoundResourse = (!$user and !$product) ? 'user and product' : (!$user ? 'user' : 'product');
            return response("$notFoundResourse not found", 404);
        }
        return ['user' => $user, 'product' => $product];
    }

    private function validateToggleOperation($user, $productId, $action)
    {
        $userHasProduct = ($user->products()->find($productId) !== null) && ($action === 'save');
        $userHasNotProduct = ($user->products()->find($productId) === null) && ($action === 'detach');
        if ($userHasProduct || $userHasNotProduct) {
            return false;
        }
        return true;
    }
}
