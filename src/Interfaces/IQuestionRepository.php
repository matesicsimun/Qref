<?php


namespace src\Interfaces;


use src\Model\Question;

interface IQuestionRepository
{
    public function saveQuestion(Question $question): int;
    public function getAllByQuizId(string $quizId): array;

    public function getQuestionById(int $questionId): Question;
}