<?php


namespace src\View;


use MongoDB\BSON\Type;
use src\Interfaces\IView;
use src\Model\AbstractClasses\Types;
use src\Model\Quiz;

class QuizEditView implements IView
{
    private Quiz $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $form = new \HTMLFormElement();
        $form->add_attribute(new \HTMLAttribute("method", "post"));
        $form->add_attribute(new \HTMLAttribute("action", "quiz_edit"));

        $hiddenQuizId = new \HTMLInputElement();
        $hiddenQuizId->add_attribute(new \HTMLAttribute("type", "hidden"));
        $hiddenQuizId->add_attribute(new \HTMLAttribute("value", $this->quiz->getQuizId()));
        $hiddenQuizId->add_attribute(new \HTMLAttribute("name", "quizId"));
        $form->add_child($hiddenQuizId);

        $h = new \HTMLHElement(3);
        $h->add_child(new \HTMLTextNode("Edit Quiz: " . $this->quiz->getName()));
        echo $h->get_html();


        $questions = $this->quiz->getQuestions();

        $br = new \HTMLBrElement();
        foreach($questions as $question){
            $form->add_child($br);
            $label = new \HTMLLabelElement();
            $label->add_child(new \HTMLTextNode("Question: " . $question->getText()));
            $form->add_child($label);
            $form->add_child($br);

            if ($question->getType() === Types::FILL_IN){
                $newCorrectInput = new \HTMLInputElement();
                $newCorrectInput->add_attribute(new \HTMLAttribute("type", "text"));
                $newCorrectInput->add_attribute(new \HTMLAttribute("id", $question->getId()));
                $newCorrectInput->add_attribute(new \HTMLAttribute("name", $question->getId()));

                $form->add_child($newCorrectInput);
                $form->add_child($br);
            } else if ($question->getType() === Types::MULTI_ONE){
                $choices = $question->getChoices();
                foreach($choices as $choice){
                    $input = new \HTMLInputElement();
                    $input->add_attribute(new \HTMLAttribute("type", "radio"));
                    $input->add_attribute(new \HTMLAttribute("value", $choice->getId()));
                    $input->add_attribute(new \HTMLAttribute("name", $question->getId()));
                    $input->add_child(new \HTMLTextNode($choice->getText()));

                    $form->add_child($input);
                    $form->add_child($br);
                }
            } else {
                $choices = $question->getChoices();
                foreach($choices as $choice){
                    $input = new \HTMLInputElement();
                    $input->add_attribute(new \HTMLAttribute("type", "checkbox"));
                    $input->add_attribute(new \HTMLAttribute("name", $question->getId()."&".$choice->getId()));
                    $input->add_attribute(new \HTMLAttribute("value", $choice->getId()));
                    $input->add_attribute(new \HTMLAttribute("id", $question->getId()));
                    $input->add_child(new \HTMLTextNode($choice->getText()));

                    $form->add_child($input);
                    $form->add_child($br);
                }
            }
        }

        $submit = new \HTMLInputElement();
        $submit->add_attribute(new \HTMLAttribute("type", "submit"));

        $form->add_child($submit);

        echo $form->get_html();
    }
}