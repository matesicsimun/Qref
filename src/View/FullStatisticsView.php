<?php


namespace src\View;


use src\Interfaces\IView;

class FullStatisticsView implements IView
{
    private array $statistics;

    public function __construct(array $statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $h1 = new \HTMLHElement(1);
        $h1->add_child(new \HTMLTextNode("Statistics"));
        $br = new \HTMLBrElement();
        echo $br->get_html();

        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("border", "true"));
        $table->add_attribute(new \HTMLAttribute("style", "text-align:center"));
        $table->add_attribute(new \HTMLAttribute("width", "600"));

        $caption = new \HTMLCaptionElement();
        $caption->add_child(new \HTMLTextNode("Full statistics"));
        $table->add_child($caption);

        $headerRow = new \HTMLRowElement();

        $quizNameHeader = new \HTMLCellElement("th");
        $quizNameHeader->add_text("Quiz");

        $dateHeader = new \HTMLCellElement("th");
        $dateHeader->add_text("Date");

        $percentage = new \HTMLCellElement("th");
        $percentage->add_text("Percentage");

        $headerRow->add_cells([$quizNameHeader, $dateHeader, $percentage]);
        $table->add_existing_row($headerRow);

        foreach($this->statistics as $statistic){
            $row = new \HTMLRowElement();

            $quiz = new \HTMLCellElement();
            $quiz->add_text($statistic->getQuizSolved()->getName());

            $date = new \HTMLCellElement();
            $date->add_text($statistic->getSolveDate()->format('Y-m-d H:i:s'));

            $percentage = new \HTMLCellElement();
            $percentage->add_text($statistic->getPercentage());

            $row->add_cells([$quiz, $date, $percentage]);
            $table->add_child($row);
        }

        echo $table->get_html();
        echo $br->get_html();
    }
}