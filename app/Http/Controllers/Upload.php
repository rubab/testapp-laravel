<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plots;
use App\Jobs\ProcessExcelData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;

class Upload extends Controller
{
    public function uploadFile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($request->hasFile('excel_file')) {
            try {
                // Retrieve the uploaded files as an array of files
                $file = $request->file('excel_file');

                // Read the Excel file
                $data = Excel::toArray([], $file);

                unset($data[0][0]);
                $chunks = array_chunk($data[0], env("CHUNK_SIZE", 100)); // Process 100 rows at a time
                // Dispatch jobs in a batch
                $batch = Bus::batch([])->dispatch();
                $batchid = 1;
                foreach ($chunks as $chunk) {
                    $rows = array_map(function ($row) use ($batchid) {
                        return [
                            'batch' => $batchid, // Add batch_id to each row
                            'city' => $row[0],
                            'society' => $row[1],
                            'block' => $row[2],
                            'marla' => $row[3],
                            'plot_size' => $row[4],
                            'price' => $row[5],
                            'status' => $row[6]
                        ];
                    }, $chunk);

                    DB::connection("sqlite")->table('temp_excel_data')->insert($rows);
                    $batch->add(new ProcessExcelData($batchid));
                    $batchid++;
                }

                return response()->json([
                    'message' => 'Processing has been started in background.',
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                'message' => "Required field missing (excel_file).",
            ], 400);
        }
    }

    public function index(Request $request)
    {

        $page = $request->query('page', 1); // Default to page 1
        $limit = $request->query('limit', 10); // Default to 10 items per page

        $plots = Plots::paginate($limit, ['*'], 'page', $page);;

        return response()->json($plots, 200);
    }
}
