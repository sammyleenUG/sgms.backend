<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BinRequest;
use App\Http\Requests\BinUpdateRequest;
use App\Models\Bin;
use Illuminate\Http\Request;
use App\Rules\Supervisor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class BinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $bins = Bin::with('BinLevels', 'AirQualities')
            ->orderBy('id', 'desc')
            ->get();

        $bins->transform(function ($bin) {
            $locationArray = explode(', ', $bin->location);

            try {
                $bin->latitude = $locationArray[0];
                $bin->longitude = $locationArray[1];

                $bin->location = getLocation($bin->latitude, $bin->longitude);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }



            return $bin;
        });

        return response(compact('bins'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'location' => 'required',
            'supervisor_id' => ['required', new Supervisor()],
            'bin_capacity' => 'required',
        ]);

        $new_bin = Bin::create([
            'location' => $validated['location'],
            'supervisor_id' => $validated['supervisor_id'],
            'bin_capacity' => $validated['bin_capacity'],
            'created_at' => now(),
        ]);

        $new_bin->update(
            [
                'bin_reference_number' => gen_ref_number($new_bin->id),
            ]
        );


        if ($new_bin) {
            return response([
                'message' => 'Bin registered successfully',
                'bin' =>  $new_bin,
            ], 200);
        } else {
            return response([
                'message' => 'Something\'s wrong',
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id): Response
    {
        try {
            $bin = Bin::findOrFail($id);
        } catch (\Exception $e) {
            return response(
                [
                    'message' => "Something's wrong",
                    'description' => $e->getMessage(),
                ],
                404
            );
        }


        return response(compact('bin'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BinRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BinRequest $request, $id): Response
    {
        $validated = $request->validate([
            'location' => 'required',
            'supervisor_id' => ['required', new Supervisor()],
            'bin_capacity' => 'required',
        ]);

        try {
            $old_bin = Bin::findOrFail($id)->update(
                [
                    'location' => $validated['location'],
                    'supervisor_id' => $validated['supervisor_id'],
                    'bin_capacity' => $validated['bin_capacity'],
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
                'bin' => $old_bin,
            ],
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id): Response
    {
        try {
            Bin::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response(
                [
                    'message' => "Failed to delete bin",
                    'error' => $e->getMessage(),
                ],
                404
            );
        }

        return response(
            [
                'message' => "Deleted bin successfully"
            ],
            200
        );
    }
}
