<?php


namespace src\Interfaces;

interface ICommentService
{
    public function saveComment(array $commentData): int;

    public function getQuizComments(string $quizId) : array;

}