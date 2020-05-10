<?php


namespace src\Repository;


use src\Interfaces\IQuizRepository;
use src\Model\Quiz;

class QuizRepository implements IQuizRepository
{

    public function saveQuiz(Quiz $quiz): int
    {
        if($this->getQuiz($quiz->getPrimaryKey())){
            return -2;
        }
        try{
            $quiz->save();
        } catch (\Exception $e){
            return -1;
        }

        return 0;
    }

    public function updateQuiz(Quiz $quiz): int
    {
        try{
            $quiz->save();
        }catch(\PDOException $p){
            return -1;
        }

        return 0;
    }

    public function getQuiz(int $id): Quiz
    {
        $quiz = new Quiz();
        $quiz->load($id);

        return $quiz;
    }

    public function getQuizByName(string $name, int $limit = 1): Quiz
    {
        $quiz = new Quiz();
        try{
            $quizArr = $quiz->loadAll("where Name = ". $name);
            if (!empty($quizArr)){
                if (count($quizArr) >= $limit){
                    return array_slice($quizArr, 0, $limit);
                }
            }
        }catch(Exception $e){

        }

    }

    public function getAllFromUsername(string $username): array
    {
        // TODO: Implement getAllFromUsername() method.
    }
}