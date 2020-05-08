<?php


namespace src\Service;


class ServiceContainer
{
    private static array $map;

    public static function register(string $name, $service){
        self::$map[$name] = $service;
    }

    public static function get($name)
    {
        if (isset(self::$map[$name])) {
            return self::$map[$name];
        }
    }
}