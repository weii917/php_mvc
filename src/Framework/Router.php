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
        $path = urldecode($path);
        // echo $path;
        // 初始都先將頭尾/去除，無論有無輸入都會匹配，才會到preg_match做處理
        $path = trim($path, "/");

        foreach ($this->routes as $route) {

            $pattern = $this->getPatternFromRoutePath($route["path"]);

            // 給予範圍定義一定要有值輸入，使用preg_match與$pattern及$path做匹配得出$matches陣列
            if (preg_match($pattern, $path, $matches)) {
                // array過濾留下的key is string
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                // 其他沒有使用{}，還有第二參數的params需要再合併到matches，返回的參數才會有controller及action的陣列
                $params = array_merge($matches, $route["params"]);
                return $params;
            }
        }
        return false;
    }

    private function getPatternFromRoutePath(string $route_path): string
    {
        $route_path = trim($route_path, "/");

        $segments = explode("/", $route_path);


        $segments = array_map(function (string $segment): string {

            //判斷是否以{}此傳入的動態形式才會執行，而$matches才會有值否則會是空的會出錯
            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {

                return "(?<" . $matches[1] . ">[^/]*)";
            }

            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) {

                return "(?<" . $matches[1] . ">" . $matches[2] . ")";
            }

            return $segment;
        }, $segments);
        // add i，"$#i"，match this pattern ignoring the case of the letters
        // add u match any Unicode character
        return "#^" . implode("/", $segments) . "$#iu";
    }
}
