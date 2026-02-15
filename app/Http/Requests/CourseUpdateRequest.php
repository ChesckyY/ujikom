<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
            'course_name' => 'sometimes|string',
            'course_category_id' => 'sometimes|integer|exists:course_categories,id',
            'course_price' => 'sometimes|integer',
            'course_description' => 'sometimes|string',
            'course_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_benefit' => 'sometimes|string',
            'is_discount' => 'sometimes|boolean',
            'discount_percentage' => 'sometimes|integer',
        ];
    }
}
