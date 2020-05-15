<?php


namespace src\Controller;


use src\View\NotFoundView;

class NotFoundController extends AbstractController
{
    public function display(){
        $this->showHtml();
    }

    protected function showHtml()
    {
        $notfoundView = new NotFoundView();
        $notfoundView->showView();
    }
}