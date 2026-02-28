<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\admin\ReportRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    protected $report_r;

    function __construct()
    {
        $this->report_r = new ReportRepositories;
    }
    //
    function index(Request $request)
    {
        return view('admin/report/index');
    }

    function monthlySales()
    {
        return view('admin.report.monthly-sales');
    }

    function doughnutChart(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');

        $request->merge([
            'month' => $month
        ]);

        $data = $this->report_r->doughnutChart($request);

        return view('admin/report/doughnut-chart', $data);
    }

    function itemSalesReport(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');

        $request->merge([
            'month' => $month
        ]);

        $data = $this->report_r->getitemSalesReport($request);


        return $data;
    }

    function salesSummary(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');

        $request->merge([
            'month' => $month
        ]);

        $data = $this->report_r->salesSummary($request);


        return view('/admin/report/sales-summary', $data);
    }
}
