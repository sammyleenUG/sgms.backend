<?php

namespace App\Http\Requests;

use App\Models\Bin;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Supervisor;
use Illuminate\Support\Facades\DB;

class BinRequest extends FormRequest
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
        return [
            'location' => 'required',
            // 'supervisor_id' => ['required', new Supervisor()],
            'bin_capacity' => 'required',
        ];
    }

    public function registerBin()
    {

       ==


        return $new_bin;
    }

    public function updateBin($id)
    {
        try {
            $old_bin = Bin::findOrFail($id)->update(
                [
                    'location' => $this->location,
                    'supervisor_id' => $this->supervisor_id,
                    'bin_capacity' => $this->bin_capacity,
                    'updated_at' => now(),
                ]
            );
        } catch (\Exception $e) {
            return response(
                [
                    'message' => "Something's wrong",
                    'description' => $e->getMessage(),
                ],
                500
            );
        }


        return response(
            [
                'message' => "Bin updated successfully",
                'data' => $old_bin,
            ],
            200,
        );
    }
}
