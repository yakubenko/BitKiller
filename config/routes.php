<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin('BitKiller', function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

