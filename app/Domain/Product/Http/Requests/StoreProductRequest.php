<?php

namespace App\Domain\Product\Http\Requests;

use App\Domain\Product\Exceptions\NotAuthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::debug('store product');
        return (Auth::id() == $this->user_id && Auth::user()->roles == 'admin');    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'   => 'required|exists:users,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'barcode' => 'required|string|unique:products,barcode',
            'quantity' => 'required|integer',
            'restock_time' => 'nullable|integer',
        ];
    }

    public function messages(){
        return [];
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
