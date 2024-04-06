<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'title' => ['required', 'max:255'],
                    'subtitle' => ['required'],
                    'description' => ['required'],
                    'images' => ['required'],
                    'images.*' => ['mimes:jpg,jpeg,png,gif', 'max:3000']
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => ['required', 'max:255'],
                    'subtitle' => ['required'],
                    'description' => ['required'],
                    'images.*' => ['mimes:jpg,jpeg,png,gif', 'max:3000']
                ];
            }
            default: break;
        }
    }
}
