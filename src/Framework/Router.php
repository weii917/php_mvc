<?php

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $path, array $params): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }

    public function match(string $path): array|bool
    {
        $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";
        // new 給予範圍定義一定要有值輸入，使用preg_match的matches過濾需要的陣列僅包含controller及action
        if (preg_match($pattern, $path, $matches)) {
            // array過濾留下的key is string
            $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
            // print_r($matches);
            // exit("Match");
            return $matches;
        }
        // 原本使用routes逐筆取得array 包含controller及action
        // foreach ($this->routes as $route) {
        //     if ($route["path"] === $path) {
        //         return $route["params"];
        //     }
        // }
        return false;
    }
}
