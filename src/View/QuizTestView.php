<?php


namespace src\View;


use src\Interfaces\IView;
use src\Model\AbstractClasses\Types;
use src\Model\Question;

class QuizTestView implements IView
{
    private array $questions;

    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $form = new \HTMLFormElement();
        $form->add_attribute(new \HTMLAttribute("action", "solve_quiz"));
        $form->add_attribute(new \HTMLAttribute("method", "post"));

        foreach($this->questions as $question){
            $form->add_children($this->getHtmlForQuestion($question));
        }

        $submit = new \HTMLInputElement();
        $submit->add_attribute(new \HTMLAttribute("type", "submit"));
        $form->add_child($submit);

        echo $form->get_html();
    }

    private function getHtmlForQuestion(Question $question):\HTMLCollection{
        $collection = new \HTMLCollection();

        $label = new \HTMLLabelElement();
        $label->add_attribute(new \HTMLAttribute("for", $question->getId()));
        $label->add_child(new \HTMLTextNode($question->getText()));

        if ($question->getType() === Types::FILL_IN){
            $input = new \HTMLInputElement();
            $input->add_attribute(new \HTMLAttribute("type", "text"));
            $input->add_attribute(new \HTMLAttribute("required", "true"));
            $input->add_attribute(new \HTMLAttribute("name", $question->getId()));
            $input->add_attribute(new \HTMLAttribute("for", $question->getId()));
        } else {
            $input = new \HTMLSelectElement();
            $input->add_attribute(new \HTMLAttribute("id", $question->getId()));
            $input->add_attribute(new \HTMLAttribute("name", $question->getId()));

            foreach($question->getChoices() as $choice){
                $option = new \HTMLOptionElement();
                $option->add_attribute(new \HTMLAttribute("value", $choice->getIsCorrect()));
                $option->add_child(new \HTMLTextNode($choice->getText()));
                $input->add_child($option);
            }
        }

        $collection->add($label);
        $collection->add($input);

        return $collection;
    }
}