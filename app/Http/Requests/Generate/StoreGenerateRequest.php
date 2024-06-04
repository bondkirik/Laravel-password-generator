<?php

namespace App\Http\Requests\Generate;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenerateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules()
    {
        return [
            'length' => 'required|integer|min:6|max:62',
            'useDigits' => 'required|boolean',
            'useUppercase' => 'required|boolean',
            'useLowercase' => 'required|boolean',
            'useCharacters' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'length.required' => 'Password length is required.',
            'length.integer' => 'Password length must be an integer.',
            'length.min' => 'Password length must be at least :min characters.',
            'length.max' => 'Password length must not exceed :max characters.',
            'useDigits.required' => 'The digits usage flag is required.',
            'useDigits.boolean' => 'The digits usage flag must be true or false.',
            'useUppercase.required' => 'The uppercase usage flag is required.',
            'useUppercase.boolean' => 'The uppercase usage flag must be true or false.',
            'useLowercase.required' => 'The lowercase usage flag is required.',
            'useLowercase.boolean' => 'The lowercase usage flag must be true or false.',
            'useCharacters.required' => 'At least one of Digits, Uppercase Letters, or Lowercase Letters must be selected.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'useDigits' => filter_var($this->useDigits, FILTER_VALIDATE_BOOLEAN),
            'useUppercase' => filter_var($this->useUppercase, FILTER_VALIDATE_BOOLEAN),
            'useLowercase' => filter_var($this->useLowercase, FILTER_VALIDATE_BOOLEAN),
        ]);

        $this->merge([
            'useCharacters' => $this->useDigits || $this->useUppercase || $this->useLowercase,
        ]);
    }
}
