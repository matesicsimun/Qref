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
        $table->add_attribute(new \HTMLAttribute("width",1500));

        $row = new \HTMLRowElement();

        $createLink = new \HTMLAElement();
        $viewLink = new \HTMLAElement();
        $statisticsLink = new \HTMLAElement();
        $challengeLink = new \HTMLAElement();

        $createLink->add_attribute(new \HTMLAttribute("href","quiz_create"));
        $viewLink->add_attribute(new \HTMLAttribute("href","quiz_view"));
        $statisticsLink->add_attribute(new \HTMLAttribute("href","quiz_statistics"));
        $challengeLink->add_attribute(new \HTMLAttribute("href","challenge"));

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