<?php

namespace App\Core\View;

use Exception;

class View
{
    private const VIEWS_PATH = __DIR__ . '/../../Views/';
    private const HEADER = self::VIEWS_PATH . '/Header/index.php';
    private const FOOTER = self::VIEWS_PATH . '/Footer/index.php';

    public static function render(string $viewName, array $args = [], bool $isView = true)
    {

        $filePath  = self::VIEWS_PATH . $viewName . '.php';

        if ($isView && !file_exists($filePath)) {
            throw new Exception('The view provided does not exist.');
        }

        extract($args);
        include self::HEADER;
        if ($isView) {
            include $filePath;
        } else {
            echo $viewName;
        }
        include self::FOOTER;
    }
}
