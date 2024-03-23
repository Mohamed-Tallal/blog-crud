<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PostRequest extends FormRequest
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
            'title_en' => ['required' , 'string', 'min:5'],
            'body_en' => ['required' , 'string', 'min:250'],
            'title_ar' => ['required' , 'string', 'min:5'],
            'body_ar' => ['required' , 'string', 'min:250'],
            'image' => ['nullable' , 'file', 'mimes:png,jpg'],
        ];
    }

}
