<?php

namespace App\Http\Controllers;

use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    private $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function getQuestions(Request $request){
        return $this->examService->prepareUserExam($request);
    }

    public function startExam(Request $request){
        return $this->examService->startExam($request);
    }

    public function resumeExam(Request $request){
        return $this->examService->resumeExam($request);
    }

    public function gradeExam(Request $request){
        return $this->examService->gradeExam($request);
    }

    public function reviewExam(Request $request){
        return $this->examService->getExamReview($request);
    }

    public function results(){
        return $this->examService->results();
    }


}
