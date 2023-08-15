<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Table;
use App\Models\User;

use App\Exports\SaleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Charts\Charts;
use App\Charts\RevenueByTable;

use Carbon\Carbon;

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
        
        $current = Carbon::now()->format('Y-m-d');

        if (!isset($request->dateStart) && !isset($request->dateEnd)) {
            $dateStart = date('Y-m-d H:i:s', strtotime($current.' 00:00:00'));
            $dateEnd = date('Y-m-d H:i:s', strtotime($current.' 23:59:59'));
        } else {
            $dateStart = date("Y-m-d H:i:s", strtotime($request->dateStart.' 00:00:00'));
            $dateEnd = date("Y-m-d H:i:s", strtotime($request->dateEnd.' 23:59:59'));
        }
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

    public function showChart(Request $request)
    {
        $current = Carbon::now()->format('Y-m-d');

        $sales = Sale::where('sale_status','paid')->orderBy('created_at');
        
        if (isset($request->dateStart) && !isset($request->dateEnd)) {
            $dateStart = date("Y-m-d H:i:s", strtotime($request->dateStart.' 00:00:00'));
            $dateEnd = date('Y-m-d H:i:s', strtotime($current.' 23:59:59'));
            $sales->whereBetween('updated_at', [$dateStart, $dateEnd]);
        } elseif (!isset($request->dateStart) && isset($request->dateEnd)) {
            $dateEnd = date("Y-m-d H:i:s", strtotime($request->dateEnd.' 23:59:59'));
            $sales->where('updated_at', '<=', $dateEnd);
        } elseif (isset($request->dateStart) && isset($request->dateEnd)) {
            $dateStart = date("Y-m-d H:i:s", strtotime($request->dateStart.' 00:00:00'));
            $dateEnd = date("Y-m-d H:i:s", strtotime($request->dateEnd.' 23:59:59'));
            $sales->whereBetween('updated_at', [$dateStart, $dateEnd]);
        }

        $sales->selectRaw('DATE_FORMAT(created_at, "%m-%Y") as month , SUM(total_price) as revenue')
        ->groupByRaw('month');

        $sales = $sales->get()->pluck('revenue', 'month');
        $chart = new Charts;
        // $chart->data
        $chart->labels($sales->keys());
        $chart->dataset('Doanh Thu (VNĐ)', 'bar', $sales->values())
        ->backgroundColor('rgba(54, 162, 235, 0.2)');
        // ->borderColor('rgb(54, 162, 235)')
        // ->borderWidth(1);

        $saleByTable = Sale::selectRaw('table_name, SUM(total_price) as revenue')
        ->groupBy('table_name');
        $saleByTable = $saleByTable->get()->pluck('revenue','table_name');
        $orderByTableChart = new RevenueByTable;
        $orderByTableChart->labels($saleByTable->keys());
        $backgroundColors = array_map('generateRandomColor', $saleByTable->keys()->toArray());

        $orderByTableChart->dataset('Doanh Thu (VNĐ)','pie', $saleByTable->values())->backgroundColor($backgroundColors);
        return view('report.charts.index', [
            'chart' => $chart,
            'orderByTableChart' => $orderByTableChart
        ]);
    } 
}
