<?php


namespace src\Interfaces;


use src\Model\Comment;

interface ICommentRepository
{
    public function saveComment(Comment $comment):int;

    public function getQuizComments(string $quizId):array;
}