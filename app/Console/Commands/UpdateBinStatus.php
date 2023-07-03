<?php

namespace App\Console\Commands;

use App\Models\Bin;
use Illuminate\Console\Command;

class UpdateBinStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bins:update_status';

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
        $bins = Bin::select('id', 'bin_capacity', 'status')->get();

        foreach ($bins as $bin) {
            $bin_level = intval(str_replace('%', '', $bin->bin_level));
            $air_quality = intval(str_replace('%', '', $bin->air_quality));

            if ($bin_level < 5 && $air_quality < 70) {
                $bin->update(['status' => 'Empty']);
            } else if ($bin_level < 70 && $air_quality < 70) {
                $bin->update(['status' => 'Filling']);
            } else if ($bin_level > 70 || $air_quality > 70) {
                $bin->update(['status' => 'Full']);
            }
        }
    }
}
