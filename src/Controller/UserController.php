<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\Interfaces\IUserService;
use src\Interfaces\IView;
use src\Model\AbstractClasses\ErrorMessages;
use src\Model\AbstractClasses\MessageCodes;
use src\Model\AbstractClasses\Messages;
use src\Repository\UserRepository;
use src\Service\ServiceContainer;
use src\View\AccountView;
use src\View\ChangePasswordView;
use src\View\HeaderView;
use src\View\HomeHeaderView;
use src\View\HomePageView;
use src\View\RegisterView;
use src\View\StatisticsView;

class UserController extends AbstractController
{
    private IUserService $userService;
    private IView $view;
    private int $messageCode;

    public function __construct()
    {
        $this->userService = ServiceContainer::get("UserService");
        $this->messageCode = 0;
    }

    public function showAccountInfo(){
        if (isLoggedIn()){
            $user = $this->userService->loadUserByUsername($_SESSION['username']);
            if($user){
                $accountView = new AccountView($user);
                $header = new HomePageView($user->getUserName());
                $header->showView();
                $accountView->showView();

                $statisticsView = new StatisticsView(ServiceContainer::get("StatisticsService")
                                                ->getViewStatisticsForUser(getSessionData('userId')));
                $statisticsView->showView();
            }else{
                redirect("index");
            }
        }else{
            redirect("index");
        }
    }

    public function changePassword(){
        if (isLoggedIn()){
            if (null == $_POST){
                $changePasswordView = new ChangePasswordView();
                $changePasswordView->showView();
            } else {
                if ($this->userService->checkPasswordForUser($_SESSION['username'], $_POST['passwordOld'])){
                    $code = $this->userService->updateUserPassword($_SESSION['username'], $_POST['passwordNew']);

                    if ($code < 0){
                        redirect("change_password?message=$code");
                    }
                }
                redirect("index");
            }
        }else{
            redirect("index");
        }
    }

    public function registerUser(){

        if (null == $_POST){
            $this->view = new RegisterView($this->getMessage());
            $this->showHtml();
        }else{
            $formData = $_POST;
            $this->messageCode = $this->userService->saveUser($formData);

            if($this->messageCode === MessageCodes::REGISTER_SUCCESSFUL){
                redirect("index?message=".$this->messageCode);
            }else{
                redirect("register?message=".$this->messageCode);
            }
        }
    }

    private function getMessage(): string{
        $msgCode = get("message", 0);
        return Messages::translateMessageCode(is_numeric($msgCode) ? $msgCode : 0);
    }

    public function logoutUser(){
        session_unset();
        session_destroy();

        $this->messageCode=MessageCodes::LOGOUT_SUCCESSFUL;
        redirect("index?message=".$this->messageCode);
    }

    public function loginUser(){
        if (null == $_POST){
            redirect("index");
        }
        $formData = $_POST;
        if (isset($formData['username']) &&
            isset($formData['password'])){

            $user = $this->userService->loadUserByUsername($formData['username']);

            if($user){
                if ($this->userService->checkPasswordForUser($formData['username'], $formData['password'])){
                    $this->updateSessionData($user->getId(), $user->getUserName());
                    $this->messageCode=MessageCodes::LOGIN_SUCCESSFUL;
                }else{
                    $this->messageCode = MessageCodes::USERNAME_PASSWORD_INCORRECT;
                }
            }else{
                $this->messageCode=MessageCodes::USER_NOT_FOUND;
            }

        }
        redirect("index?message=".$this->messageCode);
    }

    private function updateSessionData(int $id, string $username){
        $_SESSION['userId'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
    }


    protected function showHtml()
    {
        $this->view->showView();
    }
}