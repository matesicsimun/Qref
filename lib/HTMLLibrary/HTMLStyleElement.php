<?php


class HTMLStyleElement extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("style", true);
    }
}