<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     */
    protected $middleware = [];

    /**
     * Route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [],
        'api' => [],
    ];

    /**
     * Route middleware.
     */
    protected $routeMiddleware = [];
}
