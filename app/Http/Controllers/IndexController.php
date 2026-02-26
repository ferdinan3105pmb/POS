<?php

namespace App\Http\Controllers;

use App\Models\QuestionParentModel;
use App\Repositories\QuizRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $quiz_r;

    function __construct()
    {
        $this->quiz_r = new QuizRepositories();
    }

    //
    function dashboard(Request $request)
    {
        $user = Auth::guard('web')->user();
        $done_test_id = $this->quiz_r->getDoneQuizeList($user->id);
        $done_test = QuestionParentModel::whereIn('id', $done_test_id)->get();
        $data['datas'] = QuestionParentModel::where('class_id', $user->class_id)
            ->whereNotIn('id', $done_test_id)
            ->where('visible', 1)
            ->get();
        $data['done_test'] = $done_test;
        return view('quiz.index', $data);
    }

    function login_page(Request $request)
    {
        return view('login');
    }
}
