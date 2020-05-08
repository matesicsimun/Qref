<?php

namespace src\Routes;

class DefaultRoute extends AbstractRoute
{
    private string $route;

    private array $params = array();

    private array $defaults;

    private array $regex;

    public function __construct(string $route, array $defaults = array(), array $regex = array())
    {
        $basePath = "/QRef/";
        $this->route = $basePath . $route;
        $this->defaults = $defaults;
        $this->regex = $regex;
    }

    public function match(string $url)
    {

        $parts = $this->regex;
        $regex = "@^" . preg_replace_callback("/<[a-z0-9_]+>/iu", function ($match) use ($parts) {
                $name = substr($match[0], 1, strlen($match[0]) - 2);;
                return "(?P" . $match[0] . (isset($parts[$name]) ? $parts[$name] : ".+?") . ")";
            }, $this->route) . "$@uD";

        return (bool) preg_match($regex, $url, $this->params);
    }

    public function generate(array $array = array()): string
    {
        $params = array_merge($this->defaults, $array);

        $regexFirst = "@([^<]*<[a-z0-9_]+>.*)@iu";

        $replaceFunction = function ($match) use (&$replaceFunction, $regexFirst, $params) {
            $text = end($match);

            $text = preg_replace_callback("/<([a-z0-9_]+)>/i", function ($match) use ($params) {
                if (!isset($params[$match[1]])) {
                    throw new \InvalidArgumentException("Missing param " . $match[1]);
                }
                return $params[$match[1]];
            }, $text);

            return $text;
        };

        return preg_replace_callback($regexFirst, $replaceFunction, $this->route);
    }

    public function getParam(string $name, $def = null): string
    {
        if (isset($this->params[$name])){
            return $this->params[$name];
        }
        else if (isset($this->defaults[$name])){
            return $this->defaults[$name];
        }
        else{
            return $def;
        }
    }
}