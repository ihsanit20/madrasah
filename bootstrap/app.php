<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

$server_name = $_SERVER['SERVER_NAME'] ?? null;

$default_path = null;

// $default_path = "../../madrasah-env/markajulfikri.org/";

if($server_name) 
{
    $pattern = "/.test$/i";

    $domain = preg_replace($pattern, "", $server_name);

    $allow_domains = [
        'mszannat.com',
        'markajulfikri.org',
        'mazahirululoom.org',
    ];

    $path = '../../madrasah-env/' . $domain . '/';

    if(in_array($domain, $allow_domains) && file_exists($path . '.env'))
    {
        $app->useEnvironmentPath($path);
    } 
    elseif(file_exists($default_path . '.env'))
    {
        $app->useEnvironmentPath($default_path);
    }

}

// dd($app);

return $app;
