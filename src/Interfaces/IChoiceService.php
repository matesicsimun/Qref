<?php


namespace src\Interfaces;


use src\Model\AbstractClasses\Types;

interface IChoiceService
{
    public function saveChoiceFromString(string $line, int $questionId, int $type): int;
    public function getChoicesByQuestionId(int $questionId): array;

}