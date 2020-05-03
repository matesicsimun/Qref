<?php


namespace src\Controller;


class RegisterController
{

    public function __construct(array $formData = null)
    {
        if (null === $formData){
            $this->showView();
        } else {
            $this->register($formData);
        }
    }

    /**
     * Displays the registration form.
     */
    private function showView(){
        $form = new \RegisterView();
        $form->generateHtml();
    }

    /**
     * Registers a new user.
     * @param array $formData User data submitted via form.
     */
    private function register(array $formData){

    }
}