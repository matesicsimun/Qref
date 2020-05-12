<?php


namespace src\Interfaces;


use src\Model\Question;

interface IQuestionRepository
{
    public function saveQuestion(Question $question): int;
}