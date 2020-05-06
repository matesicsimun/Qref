<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\View\HeaderView;
use src\View\HomeHeaderView;

class IndexController extends AbstractController
{

    protected function doJob()
    {
        if (isLoggedIn()){
            $headerView = new HomeHeaderView(getSessionData('username'));
            $headerView->generateHtml();
        } else {
            $headerView = new HeaderView();
            $headerView->generateHtml();
        }

    }

}