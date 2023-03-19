<?php

namespace App\Services;

use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExamService
{
    public function prepareUserExam(){
        try{
            $questions = $this->getQuestions();
            $examInstance = new Exam();
            $exam = $examInstance->create($questions);
            $questions = $this->removeAnswer($exam->question);
            $data = [
                'status' => true,
                'questions' => $questions
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

    public function gradeExam(){

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

    public function getQuestions(){
        return $this->fetchQuestionsFromModel("jdjdjdjd");
    }

    public function removeAnswer($quizQuestions) {
        foreach ($quizQuestions as &$question) {
            unset($question['answer']);
        }
        return $quizQuestions;
    }

    private function fetchQuestionsFromModel($content){
        try{
            $quizQuestions = array(
                array(
                    'id' => 'kdjdkksldk',
                    'question' => 'what is bitcoin?',
                    'options' => array(
                        'A' => 'Crypto',
                        'B' => 'Naira'
                    ),
                    'answer' => 'A'
                ),
                array(
                    'id' => 'kdjdkksldk',
                    'question' => 'what is bitcoin?',
                    'options' => array(
                        'A' => 'Crypto',
                        'B' => 'Naira'
                    )
                ),
                array(
                    'id' => 'kdjdkksldk',
                    'question' => 'what is bitcoin?',
                    'options' => array(
                        'A' => 'Crypto',
                        'B' => 'Naira'
                    )
                ),
                array(
                    'id' => 'kdjdkksldk',
                    'question' => 'what is bitcoin?',
                    'options' => array(
                        'A' => 'Crypto',
                        'B' => 'Naira'
                    )
                )
            );
            return $quizQuestions;
        }
        catch(\Exception $exception){
            return $exception->getMessage();
        }
    }
}
