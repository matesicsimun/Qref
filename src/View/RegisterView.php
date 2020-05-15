<?php

namespace src\View;

use HTMLAttribute;
use HTMLFormElement;
use HTMLInputElement;
use HTMLLabelElement;
use HTMLTextNode;
use src\Interfaces\IView;

class RegisterView implements IView
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $br = new \HTMLBrElement();

        $h = new \HTMLHElement(1);
        $h->add_child(new HTMLTextNode($this->message));
        echo $h->get_html();

        echo $br->get_html();

        $textNode = new \HTMLTextNode("*Password must be at least 5 characters, at least one letter, 
                                            and at least one uppercase and lowercase letter.");
        echo $textNode->get_html();

        echo $br->get_html();
        echo $br->get_html();

        // Create base form
        $form = new HTMLFormElement();

        // Add form attributes
        $form->add_attribute(new \HTMLAttribute("action","register"));
        $form->add_attribute(new \HTMLAttribute("autocomplete","off"));
        $form->add_attribute(new \HTMLAttribute("method","post"));

        // Create input elements
        $names = ["username", "name", "surname", "birthday", "email","password","password2"];
        $types = ["text", "text", "text", "date", "email", "password", "password"];
        $ids = ["username", "name","surname", "birthday", "email", "password", "password2"];
        $attributes = [
            "username"=>["required"=>"true"],
            "name"=>["required"=>"true"],
            "surname"=>["required"=>"true"],
            "birthday"=>["required"=>"true"],
            "email"=>["required"=>"true"],
            "password"=>["pattern"=>"^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$",
                "onchange"=>"check();"],
            "password2"=>["pattern"=>"^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$",
                "onchange"=>"check();"]
        ];
        $inputElements = createInputs($types, $names, $ids, $attributes);

        // Create label elements
        $text = ["Username: ", "Name: ", "Surname: ", "Birthday: ", "Email address: ", "Password: ", "Confirm password: "];
        $for = ["username", "name", "surname", "birthday", "email", "password", "password2"];
        $labelElements = createLabels($text, $for);

        // Add to form
        for($i = 0; $i < count($inputElements); $i++){
            $form->add_child($br);
            $form->add_child($labelElements[$i]);
            $form->add_child($inputElements[$i]);
        }

        // Message field
        $span = new \HTMLSpanElement();
        $span->add_attribute(new HTMLAttribute("id", "message"));
        $form->add_child($span);
        $form->add_child($br);

        // Create JS script element
        $checkScript = new \HTMLScriptElement();
        $checkScript->add_child(new HTMLTextNode("function check() {
                    if (document.getElementById('password').value ==
                            document.getElementById('password2').value) {
                        document.getElementById('submit').disabled = false;
                        document.getElementById('message').style.color = 'green';
                        document.getElementById('message').innerHTML = 'matching';
          
                    } else {
                        document.getElementById('submit').disabled = true;
                        document.getElementById('message').style.color = 'red';
                        document.getElementById('message').innerHTML = 'not matching';
                    }
                }"));

        // Add submit button.
        $submit = new HTMLInputElement();
        $submit->add_attribute(new HTMLAttribute("type", "submit"));
        $submit->add_attribute(new HTMLAttribute("value", "Register"));
        $submit->add_attribute(new HTMLAttribute("id", "submit"));
        $submit->add_attribute(new HTMLAttribute("name", "submit"));
        $submit->add_attribute(new HTMLAttribute("disabled", "true"));
        $form->add_child($submit);

        $cancel = new \HTMLAElement();
        $cancel->add_attribute(new HTMLAttribute("href", "index"));
        $cancel->add_child(new HTMLTextNode("Cancel"));
        $form->add_child($br);
        $form->add_child($br);

        $form->add_child($cancel);

        // Show HTML
        echo $form->get_html();
        echo $checkScript->get_html();
    }
}