<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProductUserConflictRule implements ValidationRule
{
    use ProductUserConflictCheckerTrait;
    private $userId;
    private $productId;
    private $action;
    public function __construct($userId, $productId, $action)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->action = $action;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::find($this->userId);
        $this->creationCheck($user, $this->productId, $this->action);
    }
}
