<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class QuoteRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'category' => 'required|integer|exists:categories,id',
            'language' => 'required|integer|exists:languages,id',
            'text' => 'required|max:5000',
        ];

        if ($request->anonymous == false) {
            $rules['author'] = 'required|max:100';
        }

        return $rules;
    }
}
