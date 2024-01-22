<?php

namespace App\Http\Controllers\Admin\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DownloadTime;
use App\Exports\CustomerExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {   
        $d = DownloadTime::first();

        if ($d !== null) {
           $d->d_t = Carbon::now(); 
           $d->save();
        } else {
            $d = new DownloadTime;
            $d->d_t = Carbon::now(); 
            $d->save();
        }

        return Excel::download(new CustomerExport, 'customers.csv');
    }

   
}
