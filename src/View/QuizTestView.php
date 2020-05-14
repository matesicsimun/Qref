<?php


namespace src\View;


use src\Interfaces\IView;
use src\Model\AbstractClasses\Types;
use src\Model\Question;
use src\Model\Quiz;

class QuizTestView implements IView
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
        $form->add_attribute(new \HTMLAttribute("action", "quiz_solve"));
        $form->add_attribute(new \HTMLAttribute("method", "post"));

        $hiddenQuizId = new \HTMLInputElement();
        $hiddenQuizId->add_attribute(new \HTMLAttribute("type", "hidden"));
        $hiddenQuizId->add_attribute(new \HTMLAttribute("name", "quizId"));
        $hiddenQuizId->add_attribute(new \HTMLAttribute("id", "quizId"));
        $hiddenQuizId->add_attribute(new \HTMLAttribute("value", $this->quiz->getQuizId()));
        $form->add_child($hiddenQuizId);

        $title = new \HTMLHElement(1);
        $title->add_child(new \HTMLTextNode($this->quiz->getName()));
        $form->add_child($title);

        $br = new \HTMLBrElement();
        foreach($this->quiz->getQuestions() as $question){
            $form->add_children($this->getHtmlForQuestion($question));
            $form->add_child($br);
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
            $input->add_attribute(new \HTMLAttribute("id", $question->getId()));
        } else if ($question->getType() === Types::MULTI_ONE)
        {
            $input = new \HTMLSelectElement();
            $input->add_attribute(new \HTMLAttribute("id", $question->getId()));
            $input->add_attribute(new \HTMLAttribute("name", $question->getId()));

            foreach($question->getChoices() as $choice){
                $option = new \HTMLOptionElement();
                $option->add_attribute(new \HTMLAttribute("value", $choice->getId()));
                $option->add_child(new \HTMLTextNode($choice->getText()));
                $input->add_child($option);
            }
        }else{
            $collection->add($label);
            foreach($question->getChoices() as $choice){
                $in = new \HTMLInputElement();
                $in->add_attribute(new \HTMLAttribute("type", "checkbox"));
                $in->add_attribute(new \HTMLAttribute("name", $question->getId()."&".$choice->getId()));
                $in->add_attribute(new \HTMLAttribute("id", $question->getId()));
                $in->add_attribute(new \HTMLAttribute("value", $choice->getId()));
                $in->add_child(new \HTMLTextNode($choice->getText()));
                $collection->add($in);
            }

        }

        if($question->getType() != Types::MULTI_MULTI){
            $collection->add($label);
            $collection->add($input);
        }


        return $collection;
    }
}