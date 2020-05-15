<?php


namespace src\View;


use src\Interfaces\IView;
use src\Model\Quiz;

class QuizDetailsView implements IView
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
        $h = new \HTMLHElement(3);
        $h->add_child(new \HTMLTextNode("Quiz: " . $this->quiz->getName()));
        echo $h->get_html();

        $br = new \HTMLBrElement();
        echo $br->get_html();

        $h1 = new \HTMLHElement(5);
        $h1->add_child(new \HTMLTextNode("Description: " . $this->quiz->getDescription()));
        echo $h1->get_html();
        echo $br->get_html();

        $h2 = new \HTMLHElement(5);
        $h2->add_child(new \HTMLTextNode("Comments: "));
        echo $br->get_html();

        if(empty($this->quiz->getComments())){
            $h3 = new \HTMLHElement(4);
            $h3->add_child(new \HTMLTextNode("No comments yet"));
            echo $h3->get_html();
        }else{
            $comments = new \HTMLCollection();
            foreach($this->quiz->getComments() as $comment){
                $comment = new \HTMLTextNode( $comment->toString());
                $comments->add($comment);
                $comments->add(new \HTMLBrElement());
            }

            echo $comments->get_html_collection();
        }

    }
}