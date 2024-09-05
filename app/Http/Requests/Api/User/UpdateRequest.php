<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:25',
                Rule::unique('users', 'email')
                    ->ignore(
                        $this->route()->parameter('user'),
                        'uuid'
                    ),
            ],
            'phone' => ['required', 'string', 'regex:' . User::PHONE_NUMBER_REGEX],
            'position_id' => ['required', 'numeric'],
            'avatar' => ['nullable', 'file', 'mimetypes:image/jpg,image/jpeg'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone' => [
                'regex' => 'Phone number must be a Ukrainian number, should start with code of Ukraine +380',
            ],
        ];
    }
}
