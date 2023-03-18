<?php

namespace App\Services;

use App\Models\Exam;

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
