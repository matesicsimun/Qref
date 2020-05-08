<?php

namespace src\Routes;

abstract class AbstractRoute
{
    private static ?array $map = null;

    public abstract function match(string $url);

    /**
     * @param string|null $name
     * @return array|AbstractRoute|AbstractRoute[]
     */
    public static function get(string $name = null){
        if (null === $name && null !== self::$map){
            return self::$map;
        }
        if (isset(self::$map[$name])){
            return self::$map[$name];
        }
        return null;
    }

    public abstract function generate(array $array = array()): string;

    public abstract function getParam(string $name, $def = null) : string;

    public static function register(string $name, AbstractRoute $route){
        self::$map[$name] = $route;
    }
}