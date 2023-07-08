<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BinRequest;
use App\Http\Requests\BinUpdateRequest;
use App\Models\Bin;
use App\Models\BinAirquality;
use App\Models\BinLevel;
use Illuminate\Http\Request;
use App\Rules\Supervisor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function exportBinLevels(){
        return response(
            [
                'bin_levels' => BinLevel::query()
                    ->join('bins','bins.id','=','bin_levels.bin_id')
                    ->select('bins.bin_reference_number as name','bin_levels.*')
                    ->get()
            ]
        );

    }

    public function exportAirQuality(){
        return response(
            [
                'bin_air_quality' => BinAirquality::query()
                    ->join('bins','bins.id','=','bin_airqualities.bin_id')
                    ->select('bins.bin_reference_number as name','bin_airqualities.*')
                    ->get()
            ]
        );
    }

    public function singleBinLevel($id){
        return  response(
            [
                'bin_levels' =>BinLevel::query()
                    ->join('bins','bins.id','=','bin_levels.bin_id')
                    ->where('bin.id',$id)
                    ->select('bins.bin_reference_number as name','bin_levels.*')
                    ->get()
            ]
        );
    }

    public function singleAirQuality($id){
        return  response(
            [
                'bin_air_quality' => BinAirquality::query()
                    ->join('bins','bins.id','=','bin_airqualities.bin_id')
                    ->where('bin.id',$id)
                    ->select('bins.bin_reference_number as name','bin_airqualities.*')
                    ->get()
            ]
        );
    }

}
