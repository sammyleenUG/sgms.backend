<?php

namespace App\Console\Commands;

use App\Mail\notificationMail;
use App\Models\Bin;
use App\Models\BinLevel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class binEmptied extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bins:binEmptied';

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
            ->select('bins.id', 'bin_reference_number')->get();


        foreach ($bins as $bin) {

            $lastTwoBinLevels = BinLevel::query()
                ->where('bin_id',$bin->id)
                ->limit(2)
                ->orderby('id','desc')
                ->pluck('bin_level')
                ->toArray();

            if($lastTwoBinLevels && count($lastTwoBinLevels) == 2){

                $current = $lastTwoBinLevels[0];
                $previous = $lastTwoBinLevels[1];

                if($previous > 70 && $current < 70 ){
                    $title = "Bin #".substr($bin->bin_reference_number,14)." has been emptied.";
                    $icon = 'nc-icon nc-delivery-fast text-success';
                    $category = "information";

                    saveNotification($title,$icon,$category);

                    Mail::to('samttekoh@gmail.com')
                        ->cc(['lindabritney34@gmail.com', 'racheallorna@gmail.com','cnsubuga2@gmail.com'])
                        ->send(new notificationMail('Sam',$title,$category));
                }
            }
        }
    }
}
