<?php


namespace src\View;


use src\Interfaces\IView;
use src\Model\User;

class AccountView implements IView
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $p = new \HTMLPelement();
        $p->add_attribute(new \HTMLAttribute("style", "text-align:center"));
        $p->add_child(new \HTMLTextNode("Account details"));

        $table = new \HTMLTableElement();
        $table->add_attribute(new \HTMLAttribute("width", 1000));
        $table->add_attribute(new \HTMLAttribute("border", "true"));
        $row = new \HTMLRowElement();
        $row2 = new \HTMLRowElement();

        $emailHeader = new \HTMLCellElement("th");
        $dobHeader = new \HTMLCellElement("th");
        $passwordHeader = new \HTMLCellElement("th");
        $changePasswordHeader = new \HTMLCellElement("th");

        $emailCell = new \HTMLCellElement();
        $dobCell = new \HTMLCellElement();
        $passwordCell = new \HTMLCellElement();
        $changePasswordCell = new \HTMLCellElement();

        $emailHeader->add_text("Email: ");
        $dobHeader->add_text("Date of birth: ");
        $passwordHeader->add_text("Password hash: ");
        $changePasswordHeader->add_text("Change password");

        $emailCell->add_text($this->user->getEmail());
        $dobCell->add_text($this->user->getBirthDate());
        $passwordCell->add_text($this->user->getPasswordHash());

        $changePasswordLink = new \HTMLAElement();
        $changePasswordLink->add_attribute(new \HTMLAttribute("href", "change_password"));
        $changePasswordLink->add_child(new \HTMLTextNode("Change password"));
        $changePasswordCell->add_child($changePasswordLink);

        $row->add_cells([$emailHeader, $dobHeader, $passwordHeader, $changePasswordHeader]);
        $row2->add_cells([$emailCell, $dobCell, $passwordCell, $changePasswordCell]);

        $table->add_child($row);
        $table->add_child($row2);

        echo $p->get_html();
        echo $table->get_html();
    }
}