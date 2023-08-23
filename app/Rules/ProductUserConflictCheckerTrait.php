<?php

namespace App\Rules;

use App\Models\User;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait ProductUserConflictCheckerTrait
{
    public function creationCheck($user, $productId, $action) {
        $userHasProduct = ($user->products()->find($productId) !== null) && ($action === 'save');
        $userHasNotProduct = ($user->products()->find($productId) === null) && ($action === 'detach');
        if ($userHasProduct || $userHasNotProduct) {
            throw new ConflictHttpException();
        }
    }
}
