<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

use App\Enums\Gender;
use App\Enums\UserStatus;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'lastname'  => ['required', 'string', 'min:3', 'max:50'],
            'email'     => ['required', 'email', 'max:50', Rule::unique('users')->ignore($this->user->id)],
            'password'  => ['nullable', 'string', 'min:4', 'max:50', 'confirmed'],
            'gender'    => ['required', Rule::enum(Gender::class)],
            'status'    => ['required', Rule::enum(UserStatus::class)],
        ];

        $action = Route::currentRouteAction();
        $controller = explode('@', class_basename($action))[0];

        if (in_array($controller, ['StudentController', 'GuardianController'])) {
            $rules['status'] = [
                'required',
                Rule::in(
                    array_map(
                        fn($case) => $case->value,
                        array_filter(UserStatus::cases(), fn($case) => $case !== UserStatus::VACATION)
                    )
                ),
            ];
        }

        return $rules;
    }
}
