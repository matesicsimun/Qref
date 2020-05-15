<?php


namespace src\View;


use src\Interfaces\IView;

class NotFoundView implements IView
{

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $h = new \HTMLHElement(1);
        $h->add_child(new \HTMLTextNode("Not Found."));
        echo $h->get_html();

        $br = new \HTMLBrElement();
        echo $br->get_html();

        $index = new \HTMLAElement();
        $index->add_attribute(new \HTMLAttribute("href", "index"));
        $index->add_child(new \HTMLTextNode("Back to home page?"));
        echo $index->get_html();
    }
}