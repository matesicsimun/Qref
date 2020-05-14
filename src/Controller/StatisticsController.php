<?php


namespace src\Controller;


use src\Service\ServiceContainer;
use src\View\FullStatisticsView;
use src\View\HomePageView;

class StatisticsController extends AbstractController
{

    public function showStatistics(){
        if (isLoggedIn()){
            $header = new HomePageView(getSessionData('username'));
            $fullView = new FullStatisticsView(ServiceContainer::get("StatisticsService")
                                        ->getStatisticsForUser(getSessionData('userId')));
            $header->showView();
            $fullView->showView();
        }
    }

    protected function showHtml()
    {
        // TODO: Implement showHtml() method.
    }
}