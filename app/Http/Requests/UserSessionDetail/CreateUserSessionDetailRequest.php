<?php

namespace App\Http\Requests\UserSessionDetail;

use App\Traits\ApiFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserSessionDetailRequest extends FormRequest
{
    use ApiFailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required',
            'get_check_in' => 'nullable|boolean',
            'get_check_out' => 'nullable|boolean'
        ];
    }
}
