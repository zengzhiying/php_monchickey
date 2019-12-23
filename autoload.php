<?php

spl_autoload_register(function ($class_name) {
    if($class_name)
    {
        // echo $class_name;
        $file = str_replace('\\', '/', $class_name);
        $file = __DIR__ . '/' . $file . '.php';
        // echo $file;
        require_once $file;
    }
});

