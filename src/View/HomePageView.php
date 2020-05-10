<?php


namespace src\View;

/**
 * Class HomePageView
 * The home page a user sees
 * upon successful login.
 * @package src\View
 */
class HomePageView implements \src\Interfaces\IView
{
    /**
     * The username of the
     * currently logged in user.
     * @var string
     */
    private string $username;

    /**
     * A message sent from the controller.
     * @var string
     */
    private ?string $message;

    public function __construct(string $username, ?string $message = null)
    {
        $this->username = $username;
        $this->message = $message;
    }

    public function showView():void
    {
        $header = new HomeHeaderView($this->username, $this->message);
        $toolbar = new QuizToolbarView();

        $header->showView();
        $toolbar->showView();
    }
}