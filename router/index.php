<?php

$indexFiles = ['../index.php'];
$routes = [
    '^/api(/.*)?$' => '/index.php'
];

$requestedAbsoluteFile = dirname(__FILE__).$_SERVER['REQUEST_URI'];

foreach($routes as $regex => $fn)
{
    if(preg_match('%'.$regex.'%', $_SERVER['REQUEST_URI']))
    {
        $requestedAbsoluteFile = dirname(__FILE__).$fn;
        break;
    }
}

if(!preg_match('/\.php$/', $requestedAbsoluteFile))
{
    header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
    printf('"%s" does not exits', $_SERVER['REQUEST_URI']);
    return true;
}

if(!preg_match('/\.php$/', $requestedAbsoluteFile))
{
    header('Content-Type:'.mime_content_type($requestedAbsoluteFile));
    $fn = fopen($requestedAbsolute, 'r');
    $passthru($fn);
    fclose($fn);
    return true;
}

include_once $requestedAbsolute;