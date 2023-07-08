<?php

namespace App\Console\Commands;

use App\Mail\notificationMail;
use App\Models\Bin;
use App\Models\BinLevel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class recommendation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bins:recommendation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //get notifications of bin full;
        $bins = Bin::query()
            ->join('bin_levels','bins.id','=','bin_levels.bin_id')
            ->select('bins.id', 'location')->get();



        collect($bins)->transform(function($bin){

            $previous = null;
            $total_time = 0;
            $used = 1;

            $bin_levels = BinLevel::query()
                ->where('bin_id',$bin->id)
                ->select('id','bin_level AS level','created_at')
                ->get();

            foreach($bin_levels as $bin_level){
                if ($previous !== null && $previous['level'] > 70) {
                    if($bin_level->level < 70){
                        $days_passed = Carbon::parse($previous['created_at'])
                            ->diffInSeconds($bin_level->created_at);

                        $total_time +=$days_passed;
                        $used++;
                    }
                }

                $previous = [
                    'level' => $bin_level->level,
                    'created_at' => $bin_level->created_at,
                ];
            }

            $locationArray = explode(', ', $bin->location);

            try {
                $bin->location = getLocation( $locationArray[0], $locationArray[1]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }

            $avg_time = $total_time/$used;


            $bin->avg_time = $avg_time;

            return $bin;

        });

        $getFullQuickly = $bins->filter(function ($bin) {
            return $bin->avg_time < 21600;
        });

        $locations = $getFullQuickly->pluck('location')->toArray();




        $string = '';

        $unique_locations = array_unique($locations);

        foreach($unique_locations as $location){
            $string .= ','.$location;
        }

        $title = "More bins should be deployed at <b>$string</b>. These locations are getting bins filled up quickly and therefore reporting shortage in bins";
        $icon = 'nc-icon nc-bell-55 text-info';
        $category = "recommendation";

        saveNotification($title,$icon,$category);

        Mail::to('samttekoh@gmail.com')
            ->cc(['lindabritney34@gmail.com', 'racheallorna@gmail.com','cnsubuga2@gmail.com'])
            ->send(new notificationMail('Sam',$title,$category));

    }
}
