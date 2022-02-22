<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategorySubmitRequest extends FormRequest
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
            'name' => 'required|max:50',
            'slug' => [
                'required',
                Rule::unique('categories')->whereNull('deleted_at')->ignore($this->category)
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     * - - -
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['slug' => Str::slug($this->name)]);
    }
}
