<?php


namespace src\Model\Interfaces;


interface Model extends \Serializable
{
    public function equals(Model $model);
}