<?php


namespace src\Repository;


use src\Interfaces\IQuestionRepository;
use src\Model\Question;

class QuestionRepository implements IQuestionRepository
{

    public function saveQuestion(Question $question): int
    {
        try{
            $question->save();
        } catch (\Exception $e){
            return -1;
        }

        return 0;
    }
}