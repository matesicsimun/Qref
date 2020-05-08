<?php


namespace src\Controller;


class NotFoundController extends AbstractController
{
    public function display(){
        $this->showHtml();
    }

    protected function showHtml()
    {
        $errorMsg = new \HTMLPelement();
        $errorMsg->add_child(new \HTMLTextNode("Not found!"));
        echo $errorMsg->get_html();
    }
}