<?php


namespace src\View;


use src\Interfaces\IView;

class QuizResultsView implements IView
{
    private float $percentage;
    private float $points;
    private array $answers;
    private string $quizId;
    private int $userId;
    private bool $commentsEnabled;

    public function __construct(array $answers, float $points,
                                float $percentage, bool $isTimedOut,
                                string $quizId, int $userId, bool $commentsEnabled)
    {
        $this->timedOut = $isTimedOut;
        $this->percentage = $percentage;
        $this->points = $points;
        $this->answers = $answers;
        $this->quizId = $quizId;
        $this->userId = $userId;
        $this->commentsEnabled = $commentsEnabled;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {

       $h = new \HTMLHElement(1);
       $h->add_child(new \HTMLTextNode("Quiz results"));
       echo $h->get_html();

       $br = new \HTMLBrElement();
       echo $br->get_html();

       if ($this->timedOut){
           echo $br->get_html();
           $h3 = new \HTMLHElement(3);
           $h3->add_child(new \HTMLTextNode("Timed out. No points awarded"));
           echo $h3->get_html();
           echo $br->get_html();
       }

       $percent = new \HTMLHElement(2);
       $percent->add_child(new \HTMLTextNode("Percentage: " . strval($this->percentage)));
       echo $percent->get_html();
       echo $br->get_html();

       $points = new \HTMLHElement(2);
       $points->add_child(new \HTMLTextNode("Points: ". strval($this->points)));
       echo $points->get_html();
       echo $br->get_html();

       foreach($this->answers as $questionId => $answerArr){
            echo "Question: " . $questionId;
            echo $br->get_html();
            echo "user answer = " . $answerArr['userAnswer'];
            echo $br->get_html();
            echo "correct answer = " . $answerArr['correctAnswer'];
            echo $br->get_html();
            echo $br->get_html();
       }
       if ($this->commentsEnabled == 1){
           $h = new \HTMLHElement(5);
           $h->add_child(new \HTMLTextNode("Enter comment: "));
           $h->add_child(new \HTMLBrElement());
           echo $h->get_html();

           $commentForm = new \HTMLFormElement();
           $commentForm->add_attribute(new \HTMLAttribute("method", "post"));
           $commentForm->add_attribute(new \HTMLAttribute("action", "save_comment"));

           $quizIdHidden = new \HTMLInputElement();
           $quizIdHidden->add_attribute(new \HTMLAttribute("type", "hidden"));
           $quizIdHidden->add_attribute(new \HTMLAttribute("value", $this->quizId));
           $quizIdHidden->add_attribute(new \HTMLAttribute("name", "quizId"));

           $commentForm->add_child($quizIdHidden);

           $userIdHidden = new \HTMLInputElement();
           $userIdHidden->add_attribute(new \HTMLAttribute("type", "hidden"));
           $userIdHidden->add_attribute(new \HTMLAttribute("name", "userId"));
           $userIdHidden->add_attribute(new \HTMLAttribute("value", $this->userId));

           $commentForm->add_child($userIdHidden);

           $commentLabel = new \HTMLLabelElement();
           $commentLabel->add_attribute(new \HTMLAttribute("for", "comment"));
           $commentLabel->add_child(new \HTMLTextNode("Comment: "));

           $comment = new \HTMLInputElement();
           $comment->add_attribute(new \HTMLAttribute("type", "text"));
           $comment->add_attribute(new \HTMLAttribute("id", "comment"));
           $comment->add_attribute(new \HTMLAttribute("name", "comment"));

           $commentForm->add_child($comment);
           $submit = new \HTMLInputElement();
           $submit->add_attribute(new \HTMLAttribute("type", "submit"));
           $submit->add_attribute(new \HTMLAttribute("value", "Add comment"));
           $commentForm->add_child($submit);

           echo $commentForm->get_html();
       }
    }
}