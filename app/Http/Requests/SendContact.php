<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Ipsum\Core\app\Rules\NotSpammeur;

class SendContact extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required',
            'email' => ['required', 'email', new NotSpammeur()],
            'telephone' => 'nullable|min:10',
            'texte' => 'required',
        ];
    }
}
