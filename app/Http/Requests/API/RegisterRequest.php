<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true; // Остановить валидацию после первой неуспешной проверки

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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|string|min:1',
            'firstName' => 'required|string|min:1|max:255',
            'lastName' => 'required|string|min:1|max:255',
            'role' => Rule::in(['client', 'driver']),
            //'car.make' => 'required|string|min:1',
            //'car.model' => 'required|string|min:1',
            //'car.year' => 'required|string|min:1',
            //'car.color' => 'required|string|min:1',
        ];
    }
}
