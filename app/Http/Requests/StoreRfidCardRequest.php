<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRfidCardRequest extends FormRequest
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
            'card_id' => 'required|unique:rfid_cards|max:255',
            'screen_id' => 'required',
            'is_active' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'card_id.required' => 'A Card Token is required',
            'card_id.unique' => 'This Card Token is already taken',
            'card_id.max' => 'Card Token cannot be more than 255',
            'screen_id.required' => 'A screen is required',
            'is_active.required' => 'A status is required',
        ];
    }
}
