<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\View\HeaderView;
use src\View\HomeHeaderView;

class IndexController extends AbstractController
{
    public function displayHomePage()
    {
        if (isLoggedIn()){
            $headerView = new HomeHeaderView(getSessionData('username'), get("message"));
        } else {
            $headerView = new HeaderView(get("message"));
        }
        $headerView->generateHtml();
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}