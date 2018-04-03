<?php
declare(strict_types=1);

namespace Calculator\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * Class RouterFactory
 * @package Calculator\Router
 */
class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList;
        $router[] = new Route('test-issue', 'Homepage:test');
        $router[] = new Route('<presenter>/<action>', 'Homepage:default');
        return $router;
    }
}
