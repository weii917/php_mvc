<?php

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $path, array $params = []): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }

    public function match(string $path): array|bool
    {
        foreach ($this->routes as $route) {
            $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";

            echo $pattern . "\n" . $route["path"] . "\n";

            $this->getPatternFromRoutePath($route["path"]);

            // 給予範圍定義一定要有值輸入，使用preg_match的matches過濾需要的陣列僅包含controller及action
            if (preg_match($pattern, $path, $matches)) {
                // array過濾留下的key is string
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                // print_r($matches);
                // exit("Match");
                return $matches;
            }
        }
        return false;
    }

    private function getPatternFromRoutePath(string $route_path)
    {
        $route_path = trim($route_path, "/");

        $segments = explode("/", $route_path);


        $segments = array_map(function (string $segment): string {

            preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches);

            $segment = "(?<" . $matches[1] . ">)[a-z]+";

            return $segment;
        }, $segments);

        print_r($segments);
    }
}
