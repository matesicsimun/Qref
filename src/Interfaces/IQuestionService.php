<?php


namespace src\Interfaces;


interface IQuestionService
{
    public function saveQuestionsFromFile(array $fileData, string $quizId): int;

    public function saveQuestionsFromText(string $text, string $quizId): int;

    public function setNewFillInChoice(int $questionId, string $choiceText);

    public function setNewMultiChoice(int $questionId, int $choiceId);

    public function setNewMultiChoices(int $questionId, array $choiceIds);
}