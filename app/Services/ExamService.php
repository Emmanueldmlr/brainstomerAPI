<?php

namespace App\Services;

use App\Data\QuestionBank;
use App\Models\Exam;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExamService
{
    private function calculateReward($score, $total){
        $percentage = ($score/$total)*100;
        if($percentage < 50){
            return 0;
        }
        return $percentage * 10;
    }
    public function prepareUserExam(Request $request){
        try{
            $questionBank = $this->getQuestions($request->wiki_id);
            $examInstance = new Exam();
            $questions = $this->removeAnswer($questionBank["questions"]);
            $exam = $examInstance->create($questionBank["questions"]);
            $data = [
                'status' => true,
                'questions' => $questions,
                'exam_id' => $exam->id
            ];
            return response($data, 200);
        }
        catch (\Exception $exception){
            $data = [
                'status' => false,
                'message' => 'Action Could not be performed'
            ];
            return response($data, 500);
        }
    }

    public function startExam(Request $request){
        $getExam = Exam::where('id', $request->exam_id)->first();
        if(!$getExam){
            $data = [
                'status' => false,
                'message' => 'Exam does not exist'
            ];
            return response($data, 404);
        }
        $currentTime = $getExam->start_time;
        if(!$getExam->start_time){
            $currentTime = now();
            $getExam->start_time = $currentTime;
            $getExam->save();
        }
        $data = [
            'status' => true,
            'message' => 'Exam start time is successfully updated',
            'start_time' => $currentTime
        ];
        return response($data, 200);
    }

    public function resumeExam(Request $request){
        $getExam = Exam::where(['id' => $request->exam_id, 'user_id' => Auth::user()->id])->first();
        if(!$getExam){
            $data = [
                'status' => false,
                'message' => 'Exam does not exist'
            ];
            return response($data, 404);
        }
        $timeSinceStart = $this->getTImeDiff($getExam->start_time);
        if($getExam->is_completed || $timeSinceStart >= $getExam->duration ){
            $data = [
                'status' => false,
                'message' => 'Exam is over'
            ];
            return response($data, 401);
        }
        $questions = $this->removeAnswer($getExam->question);
        $data = [
            'status' => true,
            'questions' => $questions,
            'time_remaining' => $timeSinceStart
        ];
        return response($data, 200);
    }

    public function gradeExam(Request $request){
        $getExam = Exam::where(['id' => $request->exam_id, 'user_id' => Auth::user()->id])->first();
        if(!$getExam){
            $data = [
                'status' => false,
                'message' => 'Exam does not exist'
            ];
            return response($data, 404);
        }
        $score = $this->markExam($getExam->question, $request->script);
        $getExam->end_time = now();
        $getExam->is_completed = true;
        $getExam->save();
        $resultInstance = new Result();
        $totalQuestion = count($getExam->question);
        $reward = $this->calculateReward($score, $totalQuestion);
        $resultInstance->create($score,$totalQuestion ,$request->exam_id,$reward);
        $data = [
            'status' => false,
            'result' => ($score/$totalQuestion)*100,
            'reward' => $reward,
            'score' => $score,
            "msg" => "Exam Successfully completed"
        ];
        return response($data, 200);
    }

    private function markExam($markingGuides, $script){
        $score = 0;
        foreach ($script as $userAnswer) {
            $markingGuide = $markingGuides[array_search($userAnswer['id'], array_column($markingGuides, 'id'))];
            if ($userAnswer['selectedAnswer'] == $markingGuide['answer']) {
                $score++;
            }
        }
        return $score;
    }

    public function getExamReview(Request $request){
        $getExam = Exam::where(['id' => $request->exam_id, 'user_id' => Auth::user()->id])->first();
        if(!$getExam){
            $data = [
                'status' => false,
                'message' => 'Exam does not exist'
            ];
            return response($data, 404);
        }
        if(!$getExam->is_completed){
            $data = [
                'status' => false,
                'message' => 'Exam is still on'
            ];
            return response($data, 401);
        }
        $data = [
            'status' => true,
            'message' => 'Exam review successfully fetched',
            'reviews' => $getExam->question
        ];
        return response($data, 200);
    }

    public function getTImeDiff($date) {
        $timeDifferenceInSeconds = now()->diffInMinutes($date);
        return $timeDifferenceInSeconds;
    }

    public function getQuestions($wiki_id){
        return $this->fetchQuestionsFromModel($wiki_id);
    }

    public function removeAnswer($quizQuestions) {
        foreach ($quizQuestions as &$question) {
            unset($question['answer']);
        }
        return $quizQuestions;
    }

    public function results(){
        $results = Result::where("user_id", Auth::user()->id)->get();
        $data = [
            'status' => true,
            'message' => 'Results successfully fetched',
            'reviews' => $results
        ];
        return response($data, 200);
    }

    private function fetchQuestionsFromModel($wiki_id){
        try{
//            $curl = curl_init();
//            $data = [
//                'apiKey' => '385e56a2-9407-4f73-9d1a-ea76f7c64de9',
//                'modelKey' => '7cbf9f5a-ef49-4336-a2fe-785bc3e19b20',
//                'modelInputs' => [
//                    'prompt' => 'Generate ten multiple choice questions from' . $content
//                ]
//            ];
//            curl_setopt_array($curl, array(
//                CURLOPT_URL => "https://api.banana.dev/start/v4/",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_CUSTOMREQUEST => "POST",
//                CURLOPT_POSTFIELDS => json_encode($data),
//                CURLOPT_HTTPHEADER => [
//                    "content-type: application/json",
//                    "cache-control: no-cache"
//                ],
//            ));
//            $response = curl_exec($curl);
//            $result = json_decode($response);
//            dd($resultz);
//            $err = curl_error($curl);
//            return [$err, $response];
            $questionBankInstance = new QuestionBank();
            $questions = $questionBankInstance->getQuestions($wiki_id);
            return $questions;
        }
        catch(\Exception $exception){
            return $exception->getMessage();
        }
    }
}
