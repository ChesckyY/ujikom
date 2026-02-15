<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseExamStoreRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'course_exam_title' => 'required|string',
            'course_exam_description' => 'required|string',
            'course_total_question' => 'nullable|string'
        ];
    }
}
