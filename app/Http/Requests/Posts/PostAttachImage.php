<?php

namespace App\Http\Requests\Posts;

use App\Rules\Posts\ImagePlacement;
use Illuminate\Foundation\Http\FormRequest;

class PostAttachImage extends FormRequest
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
            'image'=>['required', 'mimes:jpeg,bmp,png', 'file:8192'],
            'placement'=>['required', new ImagePlacement]
        ];
    }
}
