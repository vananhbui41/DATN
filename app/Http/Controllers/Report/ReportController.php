<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Table;
use App\Models\User;

use App\Exports\SaleReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    public function index(){
        $sales = Sale::paginate(10);
        $tables = Table::all();
        $users = User::all();
        return view('report.index')
        ->with('sales', $sales)
        ->with('tables', $tables)
        ->with('users', $users);
    }

    public function show(Request $request){
        $tables = Table::all();
        $users = User::all();
        
        $request->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required'
        ]);
        $dateStart = date("Y-m-d H:i:s", strtotime($request->dateStart.' 00:00:00'));
        $dateEnd = date("Y-m-d H:i:s", strtotime($request->dateEnd.' 23:59:59'));
        $sales = Sale::whereBetween('updated_at', [$dateStart, $dateEnd])->where('sale_status','paid');
        if (isset($request->table_id)) {
            $table = Table::find($request->table_id);
            $sales->where('table_id', $table->id);
        }

        if (isset($request->user_id)) {
            $user = User::find($request->user_id);
            $sales->where('user_id', $user->id);
        }

        return view('report.showReport')
        ->with('dateStart', date("m/d/Y H:i:s", strtotime($request->dateStart.' 00:00:00')))
        ->with('dateEnd', date("m/d/Y H:i:s", strtotime($request->dateEnd.' 23:59:59')))
        ->with('totalSale', $sales->sum('total_price'))
        ->with('sales', $sales->paginate(3))
        ->with('tables', $tables)
        ->with('users', $users);
    }
    public function export(Request $request){
        return Excel::download(new SaleReportExport($request->dateStart, $request->dateEnd), 'saleReport.xlsx');
    }
}
