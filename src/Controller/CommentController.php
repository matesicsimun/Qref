<?php


namespace src\Controller;


use src\Service\ServiceContainer;

class CommentController
{
    public function saveComment(){
        if (null != $_POST){
            $messageCode = ServiceContainer::get("CommentService")->saveComment($_POST);
            redirect("index?message=".$messageCode);
        }
    }
}