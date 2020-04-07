<?php

namespace Core;

class View
{

    function fetchPartial($template, $params = [])
    {
        extract($params);
        ob_start();
        include ROOT . "/views/{$template}.phtml";
        return ob_get_clean();
    }

    function fetch($template, $params = [], $admin = false)
    {
        $content = $this->fetchPartial($template, $params);
        $layout = $admin === true ? 'layouts/admin' : 'layouts/app';
        return $this->fetchPartial($layout, ['content' => $content, 'data' => $params]);
    }

    function render($template, $params = [], $admin = false)
    {
        echo $this->fetch($template, $params, $admin);
    }


}