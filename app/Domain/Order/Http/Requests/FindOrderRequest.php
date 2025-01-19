<?php

namespace App\Domain\Order\Http\Requests;

use App\Domain\Order\Exceptions\NotAuthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class FindOrderRequest extends FormRequest
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
            'id'        => ['nullable', 'numeric', Rule::exists('orders','id')->where('user_id', $this->user_id)->where("deleted_at", null)],
            'user_id'   => 'required|exists:users,id',
            'name'      => 'nullable|string',
            'notes'     => 'nullable|string',
            'min_cost'     => 'nullable|numeric',
            'max_cost'     => 'nullable|numeric',
            'min_quantity'     => 'nullable|numeric',
            'max_quantity'     => 'nullable|numeric',
            'status'    => 'nullable|string',
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
