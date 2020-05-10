<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\View\HeaderView;
use src\View\HomeHeaderView;
use src\View\HomePageView;
use src\View\IndexView;

class IndexController extends AbstractController
{
    public function displayHomePage()
    {
        if (isLoggedIn()){
            $headerView = new HomePageView(getSessionData('username'), get("message"));
        } else {
            $headerView = new IndexView(get("message"));
        }
        $headerView->showView();
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}