<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_name' => 'required|string',
            'course_category_id' => 'required|integer|exists:course_categories,id',
            'course_price' => 'required|integer',
            'course_description' => 'required|string',
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_benefit' => 'required|string',
            'is_discount' => 'required|boolean',
            'discount_percentage' => 'sometimes|nullable',
        ];
    }
}
