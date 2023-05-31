<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class ReceitaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255']
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }

    public function setValidation(array $data)
    {
        $validator = Validator::make($data, $this->rules());
        $this->setValidator($validator);
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome da receita é obrigatório',
            'nome.string' => 'O nome da receita precisa ser do tipo texto',
            'nome.max' => 'O nome da receita pode ter no máximo 255 dígitos'
        ];
    }
}
