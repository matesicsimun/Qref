<?php


namespace src\View;

/**
 * Class HeaderView
 * Displays a login form, and the qref logo
 * @package src\View
 */
class HeaderView extends AbstractView
{
    /**
     * Displays html.
     */
    public function generateHtml()
    {
        $logo = new \HTMLImgElement();
        $logo->add_attribute(new \HTMLAttribute("src", "Images/logo.png"));

        $loginFormView = new LoginFormView();

        $registerForm = new \HTMLFormElement();
        $registerForm->add_attribute(new \HTMLAttribute("action", "index.php?action=register"));
        $registerForm->add_attribute(new \HTMLAttribute("method", "post"));
        $regBtn = new \HTMLInputElement();
        $regBtn->add_attribute(new \HTMLAttribute("type", "submit"));
        $regBtn->add_attribute(new \HTMLAttribute("value", "Register"));
        $registerForm->add_child($regBtn);

        echo $logo->get_html();
        $loginFormView->generateHtml();
        echo $registerForm->get_html();
    }
}