<?php


namespace src\Interfaces;


use src\Model\Choice;

interface IChoiceRepository
{
    public function saveChoice(Choice $choice): int;
    public function getChoicesByQuestionid(int $questionId):array;
    public function getChoiceById(int $choiceId): Choice;
}