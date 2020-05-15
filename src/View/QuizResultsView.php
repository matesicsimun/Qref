<?php


namespace src\View;


use src\Interfaces\IView;

class QuizResultsView implements IView
{
    private float $percentage;
    private float $points;
    private array $answers;

    public function __construct(array $answers, float $points, float $percentage, bool $isTimedOut)
    {
        $this->timedOut = $isTimedOut;
        $this->percentage = $percentage;
        $this->points = $points;
        $this->answers = $answers;
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
    }
}