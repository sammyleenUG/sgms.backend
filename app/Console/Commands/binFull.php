<?php

namespace App\Console\Commands;

use App\Mail\notificationMail;
use App\Models\Bin;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class binFull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bins:binFull';

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
        $bins = Bin::query()->select('id', 'bin_reference_number', 'status')->get();

        foreach ($bins as $bin) {
            if($bin->status == 'Full'){
                $supervisor = User::query()->where('id',$bin->supervisor_id)->first();

                $name = ($supervisor != null)? $supervisor->name : '(No supervisor assigned)';

                $title = "Hello $name, Bin #".substr($bin->bin_reference_number,14)." has filled up. You are getting this notification because you are the supervisor assigned to this Bin";
                $icon = 'nc-icon nc-layers-3 text-danger';

                $category = "attention";

                saveNotification($title,$icon,$category);

                Mail::to('samttekoh@gmail.com')
                    ->cc(['lindabritney34@gmail.com', 'racheallorna@gmail.com','cnsubuga2@gmail.com'])
                    ->send(new notificationMail('Sam',$title,$category));
            }
        }

    }
}
