<?php

namespace App\Http\Requests\V1\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' =>  'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'price' => 'required|decimal:2|min:1',
            'stock' => 'required|integer|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => 'categoria',
            'name' => 'nombre',
            'description' => 'descripcion',
            'price' => 'precio',
            'stock' => 'stock',
        ];
    }
}
