<?php

namespace App\Http\Requests\Team;

use App\Traits\ApiFailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RemoveMemberRequest extends FormRequest
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
            'ids' => 'array',
            'ids.*' => [
                'integer',
                Rule::exists('users_team', 'user_id')
            ],
        ];
    }
}
