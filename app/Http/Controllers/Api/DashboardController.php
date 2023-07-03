<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bin;
use App\Models\BinAirquality;
use App\Models\BinLevel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'empty_bins' => $this->empty_bins(),
            'full_bins' => $this->full_bins(),
            'filling_bins' => $this->filling_bins(),
            'bin_level__per_hour_graph' => $this->bin_level__per_hour_graph(),
            'bin_air_quality_per_hour_graph' => $this->air_quality_per_hour_graph(),
        ]);
    }

    private function empty_bins()
    {
        return Bin::where('status', 'Empty')->count();
    }

    private function full_bins()
    {
        return Bin::where('status', 'Full')->count();
    }

    private function filling_bins()
    {
        return Bin::where('status', 'Filling')->count();
    }

    private function bin_level__per_hour_graph()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $startHour = $startOfDay->format('H:i');

        $avg_bin_capacity = Bin::avg('bin_capacity');

        $data = [];


        if ($avg_bin_capacity) {
            for ($x = 1; $x <= 8; $x++) {

                $stopHour = Carbon::parse($startHour)->addHours(3)->format('H:i');

                $bin_level_average = BinLevel::whereTime('created_at', '>=', $startHour)
                    ->whereTime('created_at', '<', $stopHour)
                    ->avg('bin_level') ?? 0;

                $period = "$startHour - $stopHour";

                $percentage = round((($avg_bin_capacity -  $bin_level_average == 0? $avg_bin_capacity : $bin_level_average) /  $avg_bin_capacity) * 100, 2);

                array_push($data, [
                    'avg_bin_level' => $percentage,
                    'period' => $period
                ]);


                $startHour = $stopHour;
            }
        }


        return $data;
    }


    private function air_quality_per_hour_graph()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $startHour = $startOfDay->format('H:i');

        $data = [];


        for ($x = 1; $x <= 8; $x++) {

            $stopHour = Carbon::parse($startHour)->addHours(3)->format('H:i');

            $bin_level_average = BinAirquality::whereTime('created_at', '>=', $startHour)
                ->whereTime('created_at', '<', $stopHour)
                ->avg('bin_air_quality') ?? 0;

            $period = "$startHour - $stopHour";

            array_push($data, [
                'avg_bin_air_quality' => round($bin_level_average, 2),
                'period' => $period
            ]);


            $startHour = $stopHour;
        }

        return $data;
    }
}
