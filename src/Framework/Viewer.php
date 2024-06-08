<?php

namespace Framework;

class Viewer

{
    public function render(string $template, array $data = []): string
    {
        // print_r($data);
        extract($data, EXTR_SKIP);

        ob_start();
        require "views/$template";

        return ob_get_clean();
    }
}
