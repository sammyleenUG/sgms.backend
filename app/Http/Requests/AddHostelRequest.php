<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddHostelRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return  [
            'h_name' => 'required|String|unique:hostels',
            'hostel_location' => 'required|String',
            'hostel_latitude' => 'required',
            'hostel_longitude' => 'required',
            'hostel_min_price' => 'required|Integer',
            'hostel_max_price' => 'required|Integer',
            'hostel_amenities' => 'required|String',
            'hostel_image_url' => 'required|String',
        ];
    }
}
