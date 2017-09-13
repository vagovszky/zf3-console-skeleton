<?php

// Fix for path in the Phar archive

if(Phar::running() !== ''){
    $pathinfo = pathinfo(Phar::running(false), PATHINFO_DIRNAME);
    $path = $pathinfo . DIRECTORY_SEPARATOR . "config";
}else{
    $path = realpath(__DIR__);
}

return [
    'modules' => require __DIR__ . '/modules.config.php',
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            $path . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ]
];
