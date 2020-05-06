<?php


namespace src\View;


use MongoDB\Driver\Exception\Exception;

class LoginFormView extends AbstractView
{

    public function generateHtml()
    {
        echo $this->getHtml();
    }

    public function getForm():\HTMLFormElement
    {

        $form = new \HTMLFormElement();
        $form->add_attribute(new \HTMLAttribute("action","index.php?action=login"));
        $form->add_attribute(new \HTMLAttribute("method","post"));

        $userNameInput = new \HTMLInputElement();
        $userNameInput->add_attribute(new \HTMLAttribute("name","username"));
        $userNameInput->add_attribute(new \HTMLAttribute("id", "username"));
        $userNameInput->add_attribute(new \HTMLAttribute("value","Username"));

        $userNameLabel = new \HTMLLabelElement();
        $userNameLabel->add_child(new \HTMLTextNode("Username: "));
        $userNameLabel->add_attribute(new \HTMLAttribute("for", "username"));

        $passwordInput = new \HTMLInputElement();
        $passwordInput->add_attribute(new \HTMLAttribute("type","password"));
        $passwordInput->add_attribute(new \HTMLAttribute("name", "password"));
        $passwordInput->add_attribute(new \HTMLAttribute("id", "password"));

        $passwordLabel = new \HTMLLabelElement();
        $passwordLabel->add_child(new \HTMLTextNode("Password: "));
        $passwordLabel->add_attribute(new \HTMLAttribute("for", "password"));

        $submit = new \HTMLInputElement();
        $submit->add_attribute(new \HTMLAttribute("type","submit"));
        $submit->add_attribute(new \HTMLAttribute("value", "Login"));

        $form->add_children(new \HTMLCollection([$userNameLabel, $userNameInput, $passwordLabel, $passwordInput, $submit]));

        return $form;
    }
    public function getHtml():string
    {
        return $this->getForm()->get_html();
    }
}