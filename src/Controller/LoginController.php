<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\Interfaces\IUserService;

class LoginController extends AbstractController
{
    private IUserRepository $userRepository;
    private IUserService $userService;
    private array $formData;

    public function __construct(IUserRepository $userRepository, IUserService $userService, array $formData = null)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->formData = $formData;
    }

    protected function doJob()
    {
        if (null == $this->formData){
            redirect("index.php");
        }else{
            $this->loginUser();
        }
    }

    private function loginUser(){
        if (isset($this->formData['username']) &&
                    isset($this->formData['password'])){

            $user = $this->userRepository->getUserByUsername($this->formData['username']);
            $user = $this->userService->setUserAttributes($user);

            if ($this->userService->checkPassword($this->formData['password'], $user->getPasswordHash())){
                $this->updateSessionData($user->getId(), $user->getUserName());
            }
        }
        redirect("index.php");
    }


    private function updateSessionData(int $id, string $username){
        session_start();
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
    }
}