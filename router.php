<?php
    
    require_once 'libs/router.php';
    require_once 'app/controllers/jugador.controller.php';

    $router = new Router();

   /* $router->addMiddleware(new JWTAuthMiddleware());*/

    #                 endpoint                    verbo      controller              metodo
    $router->addRoute('jugadores'      ,            'GET',     'jugadorApiController',   'getAll');
    $router->addRoute('jugadores/:id'  ,            'GET',     'jugadorApiController',   'get');
    $router->addRoute('jugadores/:id'  ,            'DELETE',  'jugadorApiController',   'delete');
    $router->addRoute('jugadores'  ,                'POST',    'jugadorApiController',   'create');
    $router->addRoute('jugadores/:id'  ,            'PUT',     'jugadorApiController',   'update');
    
    $router->addRoute('usuarios/token'    ,            'GET',     'UserApiController',   'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
        