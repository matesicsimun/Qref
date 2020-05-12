<?php


namespace src\Interfaces;


use src\Model\Choice;

interface IChoiceRepository
{
    public function saveChoice(Choice $choice): int;
}