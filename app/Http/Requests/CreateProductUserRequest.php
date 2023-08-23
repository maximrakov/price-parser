<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\User;
use App\Rules\ProductUserConflictRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CreateProductUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->route('userId'),
            'product_id' => $this->route('productId')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'product_id' => ['required', new ProductUserConflictRule($this->route('userId'), $this->route('productId'), 'save')],
            'notification_price' => 'numeric|min:1'
        ];
    }
}
