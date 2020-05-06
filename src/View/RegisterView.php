<?php

namespace src\View;

use HTMLAttribute;
use HTMLFormElement;
use HTMLInputElement;
use HTMLLabelElement;
use HTMLTextNode;

class RegisterView extends AbstractView
{
    public function __construct()
    {
    }

    public function generateHtml()
    {

        // Create base form
        $form = new HTMLFormElement();

        // Add form attributes
        $form->add_attribute(new \HTMLAttribute("action","index.php?action=register"));
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
            "password"=>["onchange"=>"check();"],
            "password2"=>["onchange"=>"check();"]
        ];
        $inputElements = $this->createInputs($types, $names, $ids, $attributes);

        // Create label elements
        $text = ["Username: ", "Name: ", "Surname: ", "Birthday: ", "Email address: ", "Password: ", "Confirm password: "];
        $for = ["username", "name", "surname", "birthday", "email", "password", "password2"];
        $labelElements = $this->createLabels($text, $for);

        // Add to form
        for($i = 0; $i < count($inputElements); $i++){
            $form->add_child($labelElements[$i]);
            $form->add_child($inputElements[$i]);
        }

        // Message field
        $span = new \HTMLSpanElement();
        $span->add_attribute(new HTMLAttribute("id", "message"));
        $form->add_child($span);

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

        // Show HTML
        echo $form->get_html();
        echo $checkScript->get_html();
    }

    /**
     * Creates an array of HTML input elements.
     * @param array $types
     * @param array $names
     * @param array $ids
     * @param array $attributes
     * @return array
     */
    private function createInputs(array $types, array $names, array $ids, array $attributes){
        $inputs = [];

        for ($i = 0; $i < sizeof($types); $i++){
            $input = new HTMLInputElement();
            $input->add_attribute(new HTMLAttribute("type", $types[$i]));
            $input->add_attribute(new HTMLAttribute("name", $names[$i]));
            $input->add_attribute(new HTMLAttribute("id", $ids[$i]));

            if(isset($attributes[$names[$i]])){
                $curAttributes = $attributes[$names[$i]];
                foreach($curAttributes as $attrName => $attrVal){
                    $input->add_attribute(new HTMLAttribute($attrName, $attrVal));
                }
            }

            $inputs[] = $input;
        }

        return $inputs;
    }

    /**
     * Creates an array of HTML label elements.
     * @param array $text
     * @param array $for
     * @return array
     */
    private function createLabels(array $text, array $for): array{
        $labels = [];

        for ($i = 0; $i < sizeof($text); $i++){
            $label = new HTMLLabelElement();
            $label->add_child(new HTMLTextNode($text[$i]));
            $label->add_attribute(new HTMLAttribute("for", $for[$i]));

            $labels[] = $label;
        }

        return $labels;
    }

}