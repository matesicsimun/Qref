<?php


namespace src\View;


use src\Interfaces\IView;

class ChangePasswordView implements IView
{

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $textNode = new \HTMLTextNode("*Password must be at least 5 characters, at least one letter, 
                                            and at least one uppercase and lowercase letter.");
        echo $textNode->get_html();
        $br = new \HTMLBrElement();
        echo $br->get_html();
        echo $br->get_html();

        $form = new \HTMLFormElement();
        $form->add_attribute(new \HTMLAttribute("method", "post"));
        $form->add_attribute(new \HTMLAttribute("action", "change_password"));
        $form->add_attribute(new \HTMLAttribute("autocomplete", "off"));


        $passwordOld = new \HTMLInputElement();
        $passwordOld->add_attribute(new \HTMLAttribute("type", "password"));
        $passwordOld->add_attribute(new \HTMLAttribute("name", "passwordOld"));
        $passwordOld->add_attribute(new \HTMLAttribute("id", "passwordOld"));
        $passwordOld->add_attribute(new \HTMLAttribute("value", ""));
        $passwordOld->add_attribute(new \HTMLAttribute("required", "true"));

        $passwordNew = new \HTMLInputElement();
        $passwordNew->add_attribute(new \HTMLAttribute("type", "password"));
        $passwordNew->add_attribute(new \HTMLAttribute("id", "passwordNew"));
        $passwordNew->add_attribute(new \HTMLAttribute("name", "passwordNew"));
        $passwordNew->add_attribute(new \HTMLAttribute("onchange", "check()"));
        $passwordNew->add_attribute(new \HTMLAttribute("required", "true"));
        $passwordNew->add_attribute(new \HTMLAttribute("pattern",
                                    "^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$"));

        $passwordNewCheck = new \HTMLInputElement();
        $passwordNewCheck->add_attribute(new \HTMLAttribute("type", "password"));
        $passwordNewCheck->add_attribute(new \HTMLAttribute("id", "passwordNewCheck"));
        $passwordNewCheck->add_attribute(new \HTMLAttribute("name", "passwordNewCheck"));
        $passwordNewCheck->add_attribute(new \HTMLAttribute("onchange", "check()"));
        $passwordNewCheck->add_attribute(new \HTMLAttribute("required", "true"));
        $passwordNewCheck->add_attribute(new \HTMLAttribute("pattern",
                                    "^\S*(?=\S{5,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$"));

        $submit = new \HTMLInputElement();
        $submit->add_attribute(new \HTMLAttribute("type", "submit"));
        $submit->add_attribute(new \HTMLAttribute("value", "Submit"));
        $submit->add_attribute(new \HTMLAttribute("id", "submit"));
        $submit->add_attribute(new \HTMLAttribute("name", "submit"));
        $submit->add_attribute(new \HTMLAttribute("disabled", "true"));

        $pwdOldLabel = new \HTMLLabelElement();
        $pwdOldLabel->add_attribute(new \HTMLAttribute("for", "passwordOld"));

        $pwdNewLabel = new \HTMLLabelElement();
        $pwdNewLabel->add_attribute(new \HTMLAttribute("for", "passwordNew"));

        $pwdNewCheckLabel = new \HTMLLabelElement();
        $pwdNewCheckLabel->add_attribute(new \HTMLAttribute("for", "passwordNewCheck"));

        $pwdOldLabel->add_child(new \HTMLTextNode("Old password: "));
        $pwdNewLabel->add_child(new \HTMLTextNode("New password: "));
        $pwdNewCheckLabel->add_child(new \HTMLTextNode("Repeat new password: "));

        $form->add_children(new \HTMLCollection([$pwdOldLabel, $passwordOld, $br, $pwdNewLabel, $passwordNew,
                                            $br, $pwdNewCheckLabel, $passwordNewCheck, $br, $submit]));

        // Message field
        $span = new \HTMLSpanElement();
        $span->add_attribute(new \HTMLAttribute("id", "message"));
        $form->add_child($span);

        // Create JS script element
        $checkScript = new \HTMLScriptElement();
        $checkScript->add_child(new \HTMLTextNode("function check() {
                    if (document.getElementById('passwordNew').value ==
                            document.getElementById('passwordNewCheck').value) {
                        document.getElementById('submit').disabled = false;
                        document.getElementById('message').style.color = 'green';
                        document.getElementById('message').innerHTML = 'matching';
          
                    } else {
                        document.getElementById('submit').disabled = true;
                        document.getElementById('message').style.color = 'red';
                        document.getElementById('message').innerHTML = 'not matching';
                    }
                }"));

        echo $form->get_html();
        echo $checkScript;
    }
}