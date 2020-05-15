<?php


namespace src\View;


use src\Interfaces\IView;

class QuizCreateView implements IView
{
    private int $authorId;

    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {

        $headline = new \HTMLHElement(1);
        $headline->add_child(new \HTMLTextNode("Create a quiz!"));
        echo $headline->get_html();

        $form = new \HTMLFormElement();
        $form->add_attribute(new \HTMLAttribute("action", "quiz_create"));
        $form->add_attribute(new \HTMLAttribute("method", "post"));
        $form->add_attribute(new \HTMLAttribute("enctype", "multipart/form-data"));

        $authorIdHidden = new \HTMLInputElement();
        $authorIdHidden->add_attribute(new \HTMLAttribute("type", "hidden"));
        $authorIdHidden->add_attribute(new \HTMLAttribute("value", $this->authorId));
        $authorIdHidden->add_attribute(new \HTMLAttribute("name", "authorId"));

        $inputNames = ["quizName", "quizDescription", "quizFile",  "isPublic", "commentsEnabled", "timeLimit"];
        $inputTypes = ["text", "text", "file", "checkbox", "checkbox", "number"];
        $attributes = ["quizName"=>[
            "required"=>"true",
            "maxlength"=>"100"
        ], "quizDescription"=>[
            "required"=>"true",
            "maxlength"=>"300",
        ], "quizFile"=>[
            "accept"=>".qref"
        ], "timeLimit"=>[
            "max"=>500,
            "min"=>1
        ]];

        $labelNames = ["Quiz name: ", "Quiz description: ", "Quiz file: ",
                         "Quiz public?", "Comments enabled?", "Time limit in seconds:"];

        $inputs = createInputs($inputTypes,$inputNames, $inputNames, $attributes);
        $labels = createLabels($labelNames, $inputNames);

        $form->add_child($authorIdHidden);
        $br = new \HTMLBrElement();
        for($i = 0; $i < count($inputs); $i++){
            $form->add_child($br);
            $form->add_child($labels[$i]);
            $form->add_child($inputs[$i]);
        }

        $textAreaLabel = new \HTMLLabelElement();
        $textAreaLabel->add_attribute(new \HTMLAttribute("for", "quizText"));
        $textAreaLabel->add_child(new \HTMLTextNode("Quiz text (in .qref format): "));

        $textArea = new \HTMLTextAreaElement();
        $textArea->add_attribute(new \HTMLAttribute("name", "quizText"));
        $textArea->add_attribute(new \HTMLAttribute("id", "quizText"));

        $form->add_children(new \HTMLCollection([$br, $br, $br]));
        $form->add_child($textAreaLabel);
        $form->add_child($br);
        $form->add_child($textArea);
        $form->add_child($br);

        $submit = new \HTMLInputElement();
        $submit->add_attribute(new \HTMLAttribute("type", "submit"));
        $form->add_child($submit);

        echo $form->get_html();
    }
}