<?php


namespace src\View;


use src\Interfaces\IView;

class IndexView implements IView
{

    private ?string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function showView(): void
    {
        $header = new HeaderView(__($this->message));
        $rules = new \HTMLPelement();
        $rules->add_attribute(new \HTMLAttribute("style", "text-align:center"));
        $rules->add_child(new \HTMLTextNode("Welcome to the QRef quiz!"));

        $header->showView();
        echo $rules->get_html();
    }
}