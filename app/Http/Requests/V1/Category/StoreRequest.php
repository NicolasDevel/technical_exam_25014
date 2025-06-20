<?php

namespace App\Http\Requests\V1\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
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
            'name' => 'required|string|max:150|unique:categories',
            'description' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripcion',
        ];
    }
}
