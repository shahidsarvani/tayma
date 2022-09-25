<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateRfidCardRequest extends FormRequest
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
            'card_id' => 'required|max:255|unique:rfid_cards,card_id,'.$this->card->id,
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
