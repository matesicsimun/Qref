<?php


namespace src\View;

/**
 * Class HeaderView
 * Displays a login form, and the qref logo
 * @package src\View
 */
class HeaderView extends AbstractView
{
    private ?string $message = null;

    public function __construct(string $message = null)
    {
        $this->message = $message;
    }

    /**
     * Displays html.
     */
    public function generateHtml()
    {
        if ($this->message){
            echo $this->message;
        }

        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("width", "1500"));
        $row = new \HTMLRowElement();

        $logo = new \HTMLImgElement();
        $logo->add_attribute(new \HTMLAttribute("src", "Images/logo.png"));
        $logoCell = new \HTMLCellElement();
        $logoCell->add_child($logo);

        $loginFormView = new LoginFormView();
        $loginForm = $loginFormView->getForm();
        $loginFormCell = new \HTMLCellElement();
        $loginFormCell->add_child($loginForm);

        $registerFormCell = new \HTMLCellElement();
        $registerForm = new \HTMLFormElement();
        $registerForm->add_attribute(new \HTMLAttribute("action", "register"));
        $registerForm->add_attribute(new \HTMLAttribute("method", "post"));

        $regBtn = new \HTMLInputElement();
        $regBtn->add_attribute(new \HTMLAttribute("type", "submit"));
        $regBtn->add_attribute(new \HTMLAttribute("value", "Register"));
        $registerForm->add_child($regBtn);
        $registerFormCell->add_child($registerForm);

        $row->add_child($logoCell);
        $row->add_child($loginFormCell);
        $row->add_child($registerFormCell);
        $table->add_child($row);

        echo $table->get_html();
    }
}