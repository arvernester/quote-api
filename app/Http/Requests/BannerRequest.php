<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'description' => 'required|max:200',
            'is_active' => 'boolean|sometimes',
        ];

        if ($request->isMethod('post')) {
            $rules['image'] = 'required|file|image|max:2000';
        }

        return $rules;
    }
}
