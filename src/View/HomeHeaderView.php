<?php


namespace src\View;

/**
 * Class HomeHeaderView
 * The header that a logged in user sees.
 * @package src\View
 */
class HomeHeaderView extends AbstractView
{
    private array $userData;

    public function __construct(string $username)
    {
        $this->userData = array();
        $this->userData['username'] = $username;
    }

    public function generateHtml()
    {
        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("width", "700"));
        $row_1 = new \HTMLRowElement();
        $row_2 = new \HTMLRowElement();

        $accountLink = new \HTMLAElement();
        $accountLink->add_attribute(new \HTMLAttribute("href", "index.php?action=account"));
        $accountImage = new \HTMLImgElement();
        $accountImage->add_attribute(new \HTMLAttribute("src", "Images/gear.png"));
        $accountImage->add_attribute(new \HTMLAttribute("width", "30"));
        $accountImage->add_attribute(new \HTMLAttribute("height", "30"));
        $accountLink->add_child($accountImage);

        $accountCell = new \HTMLCellElement();
        $accountCell->add_child($accountLink);
        $row_1->add_child($accountCell);

        $usernameLabel = new \HTMLLabelElement();
        $usernameLabel->add_child(new \HTMLTextNode($this->userData['username']));
        $usernameCell = new \HTMLCellElement();
        $usernameCell->add_child($usernameLabel);
        $row_1->add_child($usernameCell);

        $homeLink = new \HTMLAElement();
        $homeLink->add_attribute(new \HTMLAttribute("href", "index.php"));
        $homeImage = new \HTMLImgElement();
        $homeImage->add_attribute(new \HTMLAttribute("src", "Images/home.png"));
        $homeImage->add_attribute(new \HTMLAttribute("width", "30"));
        $homeImage->add_attribute(new \HTMLAttribute("height", "30"));
        $homeLink->add_child($homeImage);
        $homeCell = new \HTMLCellElement();
        $homeCell->add_child($homeLink);
        $row_1->add_child($homeCell);

        $logoutLink = new \HTMLAElement();
        $logoutLink->add_attribute(new \HTMLAttribute("href", "logout"));
        $logoutImage = new \HTMLImgElement();
        $logoutImage->add_attribute(new \HTMLAttribute("src", "Images/logout.png"));
        $logoutImage->add_attribute(new \HTMLAttribute("width", "30"));
        $logoutImage->add_attribute(new \HTMLAttribute("height", "30"));
        $logoutLink->add_child($logoutLink);
        $logoutCell = new \HTMLCellElement();
        $logoutCell->add_child($logoutLink);
        $row_1->add_child($logoutCell);

        $table->add_child($row_1);

        echo $table->get_html();
    }
}