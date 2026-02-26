<?php

namespace App\Repositories;

use App\Models\AnswerModel;
use App\Models\QuestionParentModel;
use App\Models\QuestionsModel;
use App\Models\ReportModel;
use App\Models\ResultModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Question\Question;

class QuizRepositories
{
    function getQuestionList($id)
    {
        $data['datas'] = QuestionsModel::with('Choices')->where('question_parent_id', $id)->get();
        $data['count'] = count($data['datas']);
        $data['id'] = $id;

        return $data;
    }

    function gradeQuiz($id, $request)
    {
        $user = Auth::guard('web')->user();
        DB::beginTransaction();
        try {
            $total_question = QuestionsModel::where('question_parent_id', $id)
                ->count();
            $answers = QuestionsModel::where('question_parent_id', $id)
                ->pluck('answer_id', 'id')
                ->toArray();
            $right_answer = 0;
            $weight = 100 / $total_question;

            foreach ($answers as $key => $value) {
                if (isset($request[$key]) && intval($request[$key]) === intval($value)) {
                    $matched[$key] = $value;
                    $right_answer++;
                }
            }

            $score = round($right_answer * $weight);

            $numericItems = array_filter($request, function ($key) {
                return is_int($key);
            }, ARRAY_FILTER_USE_KEY);

            $user_answer = [];
            $now = Carbon::now();

            foreach ($numericItems as $key => $value) {
                $user_answer[] = [
                    'question_parent_id' => $id,
                    'question_id' => $key,
                    'user_id' => $user->id,
                    'choices_id' => $value,
                    'created_at' => $now,
                ];
            }

            $insert = ResultModel::insert($user_answer);

            $user_grade = [
                'user_id' => $user->id,
                'question_parent_id' => $id,
                'grade' => $score,
            ];
            $report = ReportModel::create($user_grade, $score);

            DB::commit();
            $message = [
                'status' => true,
                'message' => $score,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }

        return $message;
    }

    function getDoneQuizeList($user_id)
    {
        $id_question = ResultModel::where('user_id', $user_id)
            ->pluck('question_parent_id')
            ->unique()
            ->toArray();

        return $id_question;
    }

    function getUserQuizResult($id)
    {
        $user = Auth::guard('web')->user();
        $data['quiz'] = QuestionParentModel::with('Question')->where('id', $id)->first();
        $data['grade'] = ReportModel::where('user_id', $user->id)->where('question_parent_id', $id)->pluck('grade')->first();
        $data['count'] = QuestionsModel::where('question_parent_id', $id)->count();
        $user_answer = ResultModel::where('user_id', $user->id)
            ->where('question_parent_id', $id)
            ->get()
            ->keyBy('question_id');

        foreach ($data['quiz']->Question as $question) {
            $question->user_answer = $user_answer[$question->id]->choices_id ?? null;
        }



        return $data;
    }
}
