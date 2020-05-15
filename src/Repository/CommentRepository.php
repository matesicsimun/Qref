<?php


namespace src\Repository;


use src\Interfaces\ICommentRepository;
use src\Model\Comment;

class CommentRepository implements ICommentRepository
{

    public function saveComment(Comment $comment): int
    {
        try{
            $comment->save();
            return 0;
        }catch(\PDOException $p){
            return-1;
        }
    }

    public function getQuizComments(string $quizId): array
    {
        $comment = new Comment();
        $arr = $comment->loadAll("where QuizId = '$quizId'");
        return $arr == null ? array() : $arr;
    }
}