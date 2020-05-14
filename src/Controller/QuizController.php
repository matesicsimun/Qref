<?php


namespace src\Controller;


use src\Interfaces\IQuizService;
use src\Repository\QuizRepository;
use src\Service\ServiceContainer;
use src\View\HomeHeaderView;
use src\View\HomePageView;
use src\View\QuizCreateView;
use src\View\QuizResultsView;
use src\View\QuizTableView;
use src\View\QuizTestView;

class QuizController extends AbstractController
{
    private ?IQuizService $quizService = null;

    public function __construct()
    {
        $this->quizService = ServiceContainer::get("QuizService");
    }

    public function solveQuiz(){
        if (null == $_POST){
            if (get("quizId")){
                $quiz = $this->quizService->getQuiz(get("quizId"));
                $quizTestView = new QuizTestView($quiz);
                $quizTestView->showView();
            }
        }else{
            $results = $this->quizService->getQuizResults($_POST, isLoggedIn());
            $quizResultsView = new QuizResultsView($results['answers'], $results['points'], $results['percentage']);
            if (isLoggedIn()){
                $header = new HomePageView(getSessionData('username'));
                $header->showView();
            }
            $quizResultsView->showView();
        }
    }

    public function showQuizzes(){
        if (isLoggedIn()){
            $header = new HomeHeaderView(getSessionData("username"));

            $userQuizzes = $this->quizService->getAllByAuthor(getSessionData("userId"));
            $otherQuizzes = $this->quizService->getAllNotByAuthor(getSessionData("userId"));
            $quizTable = new QuizTableView($userQuizzes, $otherQuizzes);

            $header->showView();
            $quizTable->showView();
        } else{
            redirect("index");
        }
    }

    public function createQuiz(){
        if (isLoggedIn()){
            if (null == $_POST){
                $header = new HomePageView(getSessionData('username'));
                $quizCreate = new QuizCreateView(getSessionData('userId'));

                $header->showView();
                $quizCreate->showView();
            }else{
                $this->quizService->saveQuiz($_POST, $_FILES);
                redirect("index?message=Quiz added!");
            }
        }else{
            redirect("index");
        }
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}