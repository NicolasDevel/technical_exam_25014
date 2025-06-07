<?php

namespace App\Http\Requests\V1\auth;

use App\Models\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if (!Auth::check() || Auth::user()->role->name != 'admin') {
            $this->merge([
                'role_id' => Role::USER_ID
            ]);
        }
    }

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'password_confirmation' => 'required|string|min:8|max:20',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electronico',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmacion de la contraseña',
            'role_id' => 'rol',
        ];
    }
}
