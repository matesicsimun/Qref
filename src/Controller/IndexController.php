<?php


namespace src\Controller;


use src\View\HeaderView;

class IndexController extends AbstractController
{

    protected function doJob()
    {
        $headerView = new HeaderView();
        $headerView->generateHtml();
    }

}