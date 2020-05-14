<?php


namespace src\View;


class QuizToolbarView implements \src\Interfaces\IView
{
    public function __construct()
    {
    }

    public function showView():void
    {
        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("width",1000));

        $row = new \HTMLRowElement();
        $row->add_attribute(new \HTMLAttribute("style", "text-align:center"));

        $createLink = new \HTMLAElement();
        $viewLink = new \HTMLAElement();
        $statisticsLink = new \HTMLAElement();
        $challengeLink = new \HTMLAElement();

        $createLink->add_attribute(new \HTMLAttribute("href","quiz_create"));
        $createLink->add_child(new \HTMLTextNode("Create quiz"));

        $viewLink->add_attribute(new \HTMLAttribute("href","quiz_view"));
        $viewLink->add_child(new \HTMLTextNode("View all"));

        $statisticsLink->add_attribute(new \HTMLAttribute("href","quiz_statistics"));
        $statisticsLink->add_child(new \HTMLTextNode("Quiz statistics"));

        $challengeLink->add_attribute(new \HTMLAttribute("href", "challenge"));
        $challengeLink->add_child(new \HTMLTextNode("Challenge"));

        $links = [$createLink, $viewLink, $statisticsLink, $challengeLink];
        $cells = [];
        foreach($links as $link){
            $cell = new \HTMLCellElement();
            $cell->add_child($link);
            $cells[] = $cell;
        }

        $row->add_children(new \HTMLCollection($cells));
        $table->add_child($row);

        echo $table->get_html();
    }
}