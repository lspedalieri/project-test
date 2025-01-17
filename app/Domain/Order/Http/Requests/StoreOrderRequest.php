<?php

namespace App\Domain\Order\Http\Requests;

use App\Domain\Order\Exceptions\NotAuthorizedException;
use Illuminate\Contracts\Validation\Validator;
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
        Log::debug('create order buy');
        return Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $quantity = $this->quantity;
        return [
            'user_id'   => 'required|exists:users,id',
            'product_id'=> 'required|string|exists:products,id',
            'quantity'  => [
                'required', 
                'integer', 
                'min:1', 
            Rule::exists('products', 'id')->where(function ($q) use ($quantity) {
                $q->where('quantity','>', $quantity);
            })]
        ];
    }

    public function messages(){
        return [
            'quantity.exists'   => 'Quantity not available',
            'quantity.required' => 'must be more than zero',
            'quantity.min'      => 'At least a product',
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
