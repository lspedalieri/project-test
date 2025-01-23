<?php

namespace App\Domain\Order\Http\Requests;

use App\Domain\Order\Exceptions\NotAuthorizedException;
use App\Domain\Product\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::id() == $this->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $max_quantity = 0;
        $product = Product::where('id', $this->product_id)->first();
        if(!empty($product)) $max_quantity = $product->quantity;

        return [
            'user_id'   => 'required|exists:users,id',
            'product_id'=> 'required|integer|exists:products,id',
            'quantity'  => [
                'required', 
                'integer', 
                'min:1',
                "max:$max_quantity"
            ]
        ];
    }

    public function messages(){
        $restock_time = 0;
        $product = Product::where('id', $this->product_id)->first();
        if(!empty($product)) $restock_time = $product->restock_time;
        return [
            'product_id'        => 'Product doesn\'t exists',
            'quantity.exists'   => "Quantity not available. Buy a lower item quantity or check again in {$restock_time} days",
            'quantity.required' => 'must be more than zero',
            'quantity.min'      => 'Select a product',
            'quantity.max'      => "Quantity not available. Buy a lower item quantity or check again in {$restock_time} days",
            'quantity.integer'  => 'Quantity must be an integer number',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => 'error',
            'message' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
    protected function failedAuthorization() : NotAuthorizedException
    {
        throw new NotAuthorizedException('User id not valid.', Response::HTTP_FORBIDDEN);
    }    
}
