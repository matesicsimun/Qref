<?php


namespace src\Interfaces;


use src\Model\Quiz;

interface IQuizService
{
    public function saveQuiz(array $quizData):int;

    public function getQuiz(int $id): ?Quiz;

    public function getAll(): array;

    public function getAllByAuthor(int $authorId): array;

    public function getAllByAuthorIUserName(string $authorUserName): array;


}