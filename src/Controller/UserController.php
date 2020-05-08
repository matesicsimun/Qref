<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\Interfaces\IUserService;
use src\Repository\UserRepository;
use src\Service\ServiceContainer;
use src\View\HeaderView;
use src\View\HomeHeaderView;
use src\View\IView;
use src\View\RegisterView;

class UserController extends AbstractController
{
    private IUserService $userService;
    private IUserRepository $userRepository;
    private IView $view;
    private string $message;

    public function __construct()
    {
        $this->userService = ServiceContainer::get("UserService");
        $this->userRepository = new UserRepository();
    }

    public function registerUser(){

        if (null == $_POST){
            $this->view = new RegisterView();
            $this->showHtml();
        }else{
            $formData = $_POST;

            $user = $this->userService->createUser($formData);

            if ($user){
                $code = $this->userRepository->saveUser($user);
                if ($code < 0){
                    if ($code == -2) $this->message = "Username already exists.";
                    else  $this->message = "Something went wrong. Sorry, try again soon.";
                }else{
                    $this->message = "User successfully registered.";
                }
            } else {
                $this->message = "User registration failed.";
            }

            redirect("index?message=".$this->message);
        }

    }

    public function logoutUser(){
        session_unset();
        session_destroy();

        $this->message="You have been logged out!";
        redirect("index?message=".$this->message);
    }

    public function loginUser(){
        if (null == $_POST){
            redirect("index");
        }
        $formData = $_POST;
        if (isset($formData['username']) &&
            isset($formData['password'])){

            $user = $this->userRepository->getUserByUsername($formData['username']);

            if($user){
                $user = $this->userService->setUserAttributes($user);

                if ($this->userService->checkPassword($formData['password'], $user->getPasswordHash())){
                    $this->updateSessionData($user->getId(), $user->getUserName());
                    $this->message="Welcome back, " . $user->getUserName();
                }
            }else{
                $this->message="Incorrect username or password.";
            }

        }
        redirect("index?message=".$this->message);
    }

    private function updateSessionData(int $id, string $username){
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
    }


    protected function showHtml()
    {
        $this->view->generateHtml();
    }
}