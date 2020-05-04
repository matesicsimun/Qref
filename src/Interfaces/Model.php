<?php


namespace src\Interfaces;


interface Model extends \Serializable
{
    public function equals(Model $model);
}