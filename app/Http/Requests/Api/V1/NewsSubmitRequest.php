<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsSubmitRequest extends FormRequest
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
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ],
            'title' => 'required',
            'body' => 'nullable|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
