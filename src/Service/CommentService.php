<?php


namespace src\Service;


use src\Interfaces\ICommentRepository;
use src\Interfaces\ICommentService;
use src\Model\AbstractClasses\MessageCodes;
use src\Model\Comment;

class CommentService implements  ICommentService
{
    private ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function saveComment(array $commentData): int
    {
        $comment = $this->setCommentData($commentData);
        if ($this->commentRepository->saveComment($comment) == -1){
            return MessageCodes::COMMENTING_FAILED;
        }else{
            return MessageCodes::COMMENTING_SUCCESSFUL;
        }
    }


    private function setCommentData(array $rawData):Comment{
        $comment = new Comment();
        $comment->__set("AuthorId", $rawData['userId']);
        $comment->__set("QuizId", $rawData['quizId']);
        $comment->__set("Content", $rawData['comment']);

        return $comment;
    }

    private function setCommentAttributes(Comment &$comment){

    }

    private function constructComment(Comment $comment){
        $userService = ServiceContainer::get("UserService");

        $comment->setId($comment->getPrimaryKey());
        $comment->setAuthor($userService->loadUserById($comment->__get("AuthorId")));
        $comment->setContent($comment->__get("Content"));

        return $comment;
    }

    private function constructComments(array $comments){
        $constructed=[];

        foreach($comments as $comment){
            $constructed[] = $this->constructComment($comment);
        }
        return $constructed;
    }

    public function getQuizComments(string $quizId): array
    {
        $comments = $this->commentRepository->getQuizComments($quizId);
        return $this->constructComments($comments);
    }
}