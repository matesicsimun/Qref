<?php


namespace src\View;


use src\Interfaces\IView;

class StatisticsView implements IView
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

        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("border", "true"));
        $table->add_attribute(new \HTMLAttribute("style", "text-align:center"));
        $table->add_attribute(new \HTMLAttribute("width", "500"));

        $caption = new \HTMLCaptionElement();
        $caption->add_child(new \HTMLTextNode("Quiz statistics"));
        $table->add_child($caption);

        $headerRow = new \HTMLRowElement();

        $quizNameHeader = new \HTMLCellElement("th");
        $quizNameHeader->add_text("Quiz");

        $attemptNumberHeader = new \HTMLCellElement("th");
        $attemptNumberHeader->add_text("Attempts");

        $averagePercentage = new \HTMLCellElement("th");
        $averagePercentage->add_text("Average percentage");
        $headerRow->add_cells([$quizNameHeader, $attemptNumberHeader, $averagePercentage]);
        $table->add_child($headerRow);

        foreach($this->statistics as $statistic){
            $row = new \HTMLRowElement();
            $name = new \HTMLCellElement();
            $name->add_text($statistic->getQuizName());

            $average = new \HTMLCellElement();
            $average->add_text($statistic->getAveragePercentage());

            $attemptNumber = new \HTMLCellElement();
            $attemptNumber->add_text($statistic->getNumberOfAttempts());

            $row->add_cells([$name, $attemptNumber, $average]);
            $table->add_child($row);
        }
        echo $table->get_html();
    }

}