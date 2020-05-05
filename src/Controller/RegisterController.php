<?php


namespace src\Controller;


use src\View\RegisterView;
use src\Interfaces\IUserRepository;
use src\Interfaces\IUserService;

class RegisterController extends AbstractController
{
    private IUserService $userService;
    private IUserRepository $userRepository;
    private array $formData;
    private string $message;

    public function __construct(IUserService $userService, IUserRepository $userRepository, array $formData = null)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->formData = $formData;
    }

    protected function doJob()
    {
        if (null == $this->formData){
            $this->showView();
        } else {
            $this->register($this->formData);
        }
    }

    /**
     * Displays the registration form.
     */
    private function showView(){
        $form = new RegisterView();
        $form->generateHtml();
    }

    /**
     * Registers a new user.
     * Redirect with message.
     * @param array $formData User data submitted via form.
     */
    private function register(array $formData){

        $user = $this->userService->createUser($formData);

        if ($user){
            $this->userRepository->saveUser($user);
            $this->message = "User successfully registered.";

            redirect("index.php?message=" . $this->message);
        } else {
            $this->message = "User registration failed.";

            redirect("index.php?action=register&message=".$this->message);
        }
    }
}