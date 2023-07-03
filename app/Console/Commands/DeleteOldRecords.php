<?php

namespace App\Console\Commands;

use App\Models\Bin;
use App\Models\BinAirquality;
use App\Models\BinLevel;
use Illuminate\Console\Command;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old_records';

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
        $this->bin_levels();
        $this->air_quality();
    }

    public function bin_levels()
    {
        $maxRecords = env('BIN_LEVEL_MAX_RECORDS',1000);

        // Count the number of records in the table
        $currentCount = BinLevel::count();

        if ($currentCount > $maxRecords) {
            // Determine the number of records to delete
            $recordsToDelete = $currentCount - $maxRecords;

            // Retrieve the oldest records based on a timestamp or an auto-incrementing ID
            $oldestRecords = BinLevel::orderBy('created_at')->limit($recordsToDelete)->get();

            // Delete the oldest records
            foreach ($oldestRecords as $record) {
                $record->delete();
            }
        }
    }

    public function air_quality()
    {
        $maxRecords = env('AIR_QUALITY_MAX_RECORDS',1000);

        // Count the number of records in the table
        $currentCount = BinAirquality::count();

        if ($currentCount > $maxRecords) {
            // Determine the number of records to delete
            $recordsToDelete = $currentCount - $maxRecords;

            // Retrieve the oldest records based on a timestamp or an auto-incrementing ID
            $oldestRecords = BinAirquality::orderBy('created_at')->limit($recordsToDelete)->get();

            // Delete the oldest records
            foreach ($oldestRecords as $record) {
                $record->delete();
            }
        }
    }
}
