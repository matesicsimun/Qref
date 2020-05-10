<?php


namespace src\Interfaces;


use src\Model\Quiz;

interface IQuizRepository
{
    public function saveQuiz(Quiz $quiz): int;

    public function updateQuiz(Quiz $quiz): int;

    public function getQuiz(int $id): Quiz;

    public function getQuizByName(string $name): Quiz;

    public function getAllFromUsername(string $username, int $limit): array;


}