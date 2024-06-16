<?php

namespace Framework;

class Viewer

{
    public function render(string $template, array $data = []): string
    {
        // print_r($data);
        extract($data, EXTR_SKIP);

        ob_start();
        
        require dirname(__DIR__, 2) . "/views/$template";

        return ob_get_clean();
    }
}
