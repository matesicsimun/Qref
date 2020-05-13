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

    public function getAllByQuizId(string $quizId): array
    {
        $question = new Question();
        return $question->loadAll("Where quizId = '$quizId'");
    }

    public function getQuestionById(int $questionId): Question
    {
        $question = new Question();
        $question->load($questionId);

        return $question;
    }
}