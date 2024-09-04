<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:60'],
            'last_name' => ['required', 'string', 'min:2', 'max:60'],
            'email' => ['required', 'email:rfc', 'max:25', Rule::unique('users', 'email')],
            'phone' => ['required', 'string', 'regex:' . User::PHONE_NUMBER_REGEX],
            'position_id' => ['required', 'numeric'],
            'avatar' => ['required', 'file', 'mimetypes:image/jpg,image/jpeg'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone' => [
                'regex' => 'Phone number, should start with code of Ukraine +380',
            ],
        ];
    }
}
