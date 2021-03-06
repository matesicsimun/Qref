<?php


namespace src\Interfaces;


use src\Model\Quiz;

interface IQuizService
{
    public function saveQuiz(array $quizData, array $fileData):int;

    public function getQuiz(string $id): ?Quiz;

    public function getAll(): array;

    public function getAllByAuthor(int $authorId): array;

    public function getAllByAuthorIUserName(string $authorUserName): array;

    public function getQuizResults(array $solvedQuizData, bool $isLoggedIn):array;

    public function updateQuiz(array $quizData);

    public function getQuizByIdShallow(string $quizId);
}