<?php


class HTMLHElement extends HTMLElement
{
    public function __construct(string $size)
    {
        parent::__construct("h".$size, "true");
    }
}