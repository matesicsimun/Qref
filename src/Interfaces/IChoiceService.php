<?php


namespace src\Interfaces;


use src\Model\AbstractClasses\Types;
use src\Model\Choice;

interface IChoiceService
{
    public function saveChoiceFromString(string $line, int $questionId, int $type): int;
    public function getChoicesByQuestionId(int $questionId): array;
    public function getChoiceById(int $choiceId):Choice;
}