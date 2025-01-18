<?php

namespace App\Domain\Order\Http\Requests;

use App\Domain\Order\Exceptions\NotAuthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UpdateOrderRequest extends FormRequest
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
        return [
            'user_id'   => 'required|exists:users,id',
            'id'    => [
                'required',
                Rule::exists('orders','id')->where('user_id', $this->user_id)
            ],
            'notes' => 'nullable|string',
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
