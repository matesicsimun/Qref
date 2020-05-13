<?php


namespace src\Interfaces;


use src\Model\Quiz;

interface IQuizRepository
{
    public function saveQuiz(Quiz $quiz): int;

    public function updateQuiz(Quiz $quiz): int;

    public function getQuiz(string $id): ?Quiz;

    public function getAll():array;

    public function getQuizByName(string $name): ?Quiz;

    public function getAllFromUsername(string $username): array;

    public function getAllByAuthorId(int $authorId) : array;

}