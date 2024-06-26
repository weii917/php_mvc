<?php

namespace Framework;

use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;

class Dispatcher
{
    // 直接在參數中建立private 並將參數指派給他
    public function __construct(
        private Router $router,
        private Container $container
    ) {
    }

    public function handle($path)
    {
        // match 輸入的url是否匹配上述的$router->add
        $params = $this->router->match($path);

        // print_r($params);
        if ($params === false) {
            throw new PageNotFoundException("No route matched for '$path' ");
        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);
        // exit($action);
        // 實例化後的controller
        $controller_object = $this->container->get($controller);

        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];
        $method = new ReflectionMethod($controller, $action);
        // getParameters()得到的是array所以逐筆列出參數的名稱getName()
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }
        return $args;
    }

    private function getControllerName(array $params): string
    {
        $controller = $params['controller'];
        $controller = str_replace("-", "", ucwords(strtolower($controller), "-"));
        $namespace = "App\Controllers";

        if (array_key_exists("namespace", $params)) {
            $namespace .= "\\" . $params["namespace"];
        }

        return $namespace . "\\" . $controller;
    }

    private function getActionName(array $params): string
    {
        $action = $params['action'];
        $action = lcfirst(str_replace("-", "", ucwords(strtolower($action), "-")));
        return $action;
    }

    // new ReflectionClass getobject to new class(Controller)

}
