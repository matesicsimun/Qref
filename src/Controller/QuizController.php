<?php


namespace src\Controller;


use src\Interfaces\IQuizService;
use src\Service\ServiceContainer;
use src\View\HomePageView;
use src\View\QuizCreateView;

class QuizController extends AbstractController
{
    private ?IQuizService $quizService = null;

    public function __construct()
    {
        $this->quizService = ServiceContainer::get("QuizService");
    }

    public function createQuiz(){
        if (null == $_POST){
            $header = new HomePageView(getSessionData('username'));
            $quizCreate = new QuizCreateView(getSessionData('userId'));

            $header->showView();
            $quizCreate->showView();
        }else{
            $this->quizService->saveQuiz($_POST);
            redirect("index?message=Quiz added!");
        }
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}