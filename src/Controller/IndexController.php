<?php


namespace src\Controller;


use src\Interfaces\IUserRepository;
use src\Model\AbstractClasses\Messages;
use src\View\HeaderView;
use src\View\HomeHeaderView;
use src\View\HomePageView;
use src\View\IndexView;

class IndexController extends AbstractController
{
    public function displayHomePage()
    {
        $msgCode = get("message", 0);
        $message = Messages::translateMessageCode(is_numeric($msgCode) ? $msgCode : 0);

        if (isLoggedIn()){
            $headerView = new HomePageView(getSessionData('username'), $message);
        } else {
            $headerView = new IndexView($message);
        }
        $headerView->showView();
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}