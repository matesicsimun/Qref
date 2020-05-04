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
        $names = ["name", "surname", "birthday", "email", "password", "password2"];
        $types = ["text", "text", "date", "text", "password", "password"];
        $ids = ["name","surname", "birthday", "email", "password", "password2"];
        $inputElements = $this->createInputs($types, $names, $ids);

        // Create label elements
        $text = ["Name: ", "Surname: ", "Birthday: ", "Email address: ", "Password: ", "Repeat password: "];
        $for = ["name", "surname", "birthday", "email", "password", "password2"];
        $labelElements = $this->createLabels($text, $for);

        for($i = 0; $i < count($inputElements); $i++){
            $form->add_child($labelElements[$i]);
            $form->add_child($inputElements[$i]);
        }

        // Add submit button.
        $submit = new HTMLInputElement();
        $submit->add_attribute(new HTMLAttribute("type", "submit"));
        $submit->add_attribute(new HTMLAttribute("value", "Register"));
        $form->add_child($submit);

        // Show HTML
        echo $form->get_html();
    }

    /**
     * Creates an array of HTML input elements.
     * @param array $types
     * @param array $names
     * @param array $ids
     * @return array
     */
    private function createInputs(array $types, array $names, array $ids){
        $inputs = [];

        for ($i = 0; $i < sizeof($types); $i++){
            $input = new HTMLInputElement();
            $input->add_attribute(new HTMLAttribute("type", $types[$i]));
            $input->add_attribute(new HTMLAttribute("name", $names[$i]));
            $input->add_attribute(new HTMLAttribute("id", $ids[$i]));

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