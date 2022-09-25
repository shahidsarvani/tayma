<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            //
            'content_en' => 'required',
            'content_ar' => 'required',
            'image_en' => 'image|file|size:2048',
            'image_ar' => 'image|file|size:2048',
            'sort_order' => 'required',
            'rfid_card_id' => 'required',
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'content_en.required' => 'Content (English) is required',
            'content_ar.required' => 'Content (Arabic) is required',
            'image_en.image' => 'Image (English) must be an image',
            'image_en.size' => 'Image (English) size must not be greater than 2MB',
            'image_ar.image' => 'Image (Arabic) must be an image',
            'image_ar.size' => 'Image (Arabic) size must not be greater than 2MB',
            'sort_order' => 'Sort order is required',
            'rfid_card_id' => 'RFID card token is required',
            'is_active' => 'Status is required',
        ];
    }
}
