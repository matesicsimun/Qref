<?php


namespace src\Model\Interfaces;

interface DBModel extends Model{
    public function save();

    public function load($pk);

    public function delete();
}