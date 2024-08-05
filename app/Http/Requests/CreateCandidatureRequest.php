<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateCandidatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'firstname' => ['required'],
            'adresse' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'file' => ['required', 'mime:pdf'],
            'motivation' => ['required'],
            'profil' => ['required|unique'],
            'category_id' => ['required|exists:categories|unique']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->input('name') ?: Str::slug($this->input('firstname')) // Utilisation de Str::slug pour une conversion sécurisée
        ]);
    }
}
