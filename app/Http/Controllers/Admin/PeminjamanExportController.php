<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use Illuminate\Support\Facades\Log;

class PeminjamanExportController extends Controller
{
    public function export()
    {
        try {
            $export = new PeminjamanExport();
            return Excel::download($export, 'data_peminjaman.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
