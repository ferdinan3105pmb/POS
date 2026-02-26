<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\admin\QuizRepositories;
use App\Repositories\admin\ReportRepositories;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $report_r, $quiz_r;

    function __construct()
    {
        $this->report_r = new ReportRepositories;
        $this->quiz_r = new QuizRepositories;
    }
    //
    function index(Request $request)
    {
        return view('admin/report/index');
    }

    function data(Request $request)
    {
        $data['quiz'] = $this->quiz_r->getQuiz($request);
        return view('admin.report.data', $data);
    }

    function dataReport(Request $request, $id)
    {
        $data['id'] = $id;
        return view('admin/report/view', $data);
    }

    function dataReportDetail(Request $request, $id)
    {
        $data['reports'] = $this->report_r->getReport($request, $id);
        $data['id'] = $id;
        return view('admin.report.data-report', $data);
    }


}
