<?php

namespace Core;

use Exception;

class App
{
    /**
     * @var array
     */
    private static $query = [];
    /**
     * @var array
     */
    private static $params = [];
    /**
     * @var array|string
     */
    private static $body;
    private static $method;
    private static $files;

    /**
     * @var array
     */
    protected $defaultController = 'Home';
    protected $defaultAction = 'index';
    /**
     * @var string
     */
    private $controllerName = '';
    /**
     * @var string
     */
    private $controllerAction = '';


    public function __construct()
    {
        $uri = $this->getURI();
        $tmp = explode('?', $uri);
        $request = $tmp[0];
        $queryParams = isset($tmp[1]) ? $tmp[1] : false;
        $tokens = explode('/', $request);
        if (!empty($tokens[0])) {
            if ($tokens[0] === 'dashboard') {
                array_shift($tokens);
                $this->controllerName = 'Dashboard\\' . (!empty($tokens[0]) ? ucfirst(array_shift($tokens)) : ucfirst($this->defaultController));
            } else {
                $this->controllerName = ucfirst(array_shift($tokens));
            }
        } else {
            $this->controllerName = ucfirst($this->defaultController);
        }

        $this->controllerAction = !empty($tokens[0]) ? array_shift($tokens) : $this->defaultAction;
        self::$method = $_SERVER['REQUEST_METHOD'];
        if ($queryParams) {
            self::$query = $this->parseQuerySet($queryParams);
        }
        self::$params = $tokens;
        self::$body = $this->_cleanInputs($_POST);
        self::$files = $_FILES;
    }

    private function parseQuerySet(string $queryString): array
    {
        $result = [];
        $query = explode('&', $queryString);
        foreach ($query as $value) {
            $inner = explode('=', $value);
            if (array_key_exists($inner[0], $result)) {
                array_push($result[$inner[0]], $inner[1]);
            } else {
                $result[$inner[0]] = [$inner[1]];
            }
        }
        return $result;
    }


    private function getURI(): string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


    public function run()
    {
        Config::init();
        $controllerName = 'Controllers\\' . $this->controllerName;
        if (class_exists($controllerName)) {
            $controller = new $controllerName;
            if (method_exists($controller, $this->controllerAction)) {
                $controller->{$this->controllerAction}();
            }else{
                App::error404();
            }
        }else{
            App::error404();
        }


    }

    public static function getQuery()
    {
        return self::$query;
    }

    public static function getFiles()
    {
        return self::$files;
    }

    public static function getMethod()
    {
        return self::$method;
    }


    public static function getBody()
    {
        return self::$body;
    }


    public static function getParams()
    {
        return self::$params;
    }

    private function _cleanInputs($data)
    {
        $clean_input = [];
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }


    public static function redirect(string $route)
    {
        header("Location: $route");
    }


    public static function error404()
    {
        header('HTTP/1.1 404 Not Found');
        include ROOT . '/views/404.html';
        exit();

    }


}