<?php

namespace src\View;

abstract class AbstractView implements IView
{
    public abstract function generateHtml();
}