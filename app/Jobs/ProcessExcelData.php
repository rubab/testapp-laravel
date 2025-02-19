<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessExcelData implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchid;

    /**
     * Create a new job instance.
     */
    public function __construct($batchid)
    {
        $this->batchid = $batchid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch data from the temporary SQLite database
        $data = DB::connection('sqlite')->table('temp_excel_data')->where("batch", $this->batchid)->get()->toArray();

        // Process each row of data
        foreach ($data as $row) {
            // Save to the main database
            $d = [
                "batch" => $row->batch,
                'city' => $row->city,
                'society' => $row->society,
                'block' => $row->block,
                'marla' => $row->marla,
                'plot_size' => $row->plot_size,
                'price' => $row->price,
                'status' => $row->status
            ];
            \App\Models\Plots::create($d);
        }
        // Delete rows 
        DB::connection('sqlite')->table('temp_excel_data')->where("batch", $this->batchid)->delete();
    }
}
