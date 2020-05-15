<?php


namespace src\Repository;


use src\Interfaces\IQuizRepository;
use src\Model\Quiz;

class QuizRepository implements IQuizRepository
{

    public function saveQuiz(Quiz $quiz): int
    {
        if($this->getQuizByName($quiz->__get("Name"))){
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

    public function getQuiz(string $id): ?Quiz
    {
        $quiz = new Quiz();
        $quiz->load($id);

        return $quiz;
    }

    public function getQuizByName(string $name): ?Quiz
    {
        $quiz = new Quiz();
        try{
            $quizArr = $quiz->loadAll(" where Name = '$name'");
            if (!empty($quizArr)){
                return $quizArr[0];
            }
        }catch(Exception $e){

        }
        return null;
    }

    public function getAllFromUsername(string $username): array
    {
        // TODO: Implement getAllFromUsername() method.
    }

    public function getAll(): array
    {
        $quiz = new Quiz();
        return $quiz->loadAll();
    }

    public function getAllByAuthorId(int $authorId): array
    {
        $quiz = new Quiz();
        $arr = $quiz->loadAll("where authorId = '$authorId'");

        return $arr == null ? array() : $arr;
    }
}