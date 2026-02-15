<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMaterialUpdateRequest extends FormRequest
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
            'course_id' => 'sometimes|integer|exists:courses,id',
            'course_material_title' => 'sometimes|string',
            'course_material_description' => 'sometimes|string',
            'course_material_modul' => 'sometimes|file|mimes:pdf,doc,docx,ppt,pptx',
            'course_material_video' => 'sometimes|file|mimes:mp4,webm,ogg',
        ];
    }
}
