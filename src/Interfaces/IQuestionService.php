<?php


namespace src\Interfaces;


interface IQuestionService
{
    public function saveQuestionsFromFile(array $fileData, string $quizId): int;

    public function saveQuestionsFromText(string $text, string $quizId): int;
}