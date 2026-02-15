<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMaterialStoreRequest extends FormRequest
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
            'course_id' => 'required|integer|exists:courses,id',
            'course_material_title' => 'required|string',
            'course_material_description' => 'required|string',
            'course_material_modul' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'course_material_video' => 'nullable|file|mimes:mp4,webm,ogg',
        ];
    }
}
