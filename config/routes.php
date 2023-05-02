<?php

use Slim\App;
use App\Middleware\CleApiMiddleware;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // // Films
    // $app->get('/film', \App\Action\Film\FilmViewAction::class);

    // Ajouter un fakemon.
    $app->post('/fakemon', \App\Action\Fakemon\AjoutFakemonAction::class)->add(CleApiMiddleWare::class);

    // Modifier un fakemon.
    $app->put('/fakemon/{id}', \App\Action\Fakemon\UpdateFakemonAction::class)->add(CleApiMiddleWare::class);

    // Supprimer un fakemon.
    $app->delete('/fakemon/{id}', \App\Action\Fakemon\DeleteFakemonAction::class)->add(CleApiMiddleWare::class);

    // Donne la liste des fakemons de l'usager.
    $app->get('/fakemon', \App\Action\Fakemon\FakemonAction::class)->add(CleApiMiddleWare::class);

    // Donne la liste des types
    $app->get('/type', \App\Action\Fakemon\TypeAction::class)->add(CleApiMiddleWare::class);

    // Donne l'api key selon l'usager
    $app->get('/apikey', \App\Action\Fakemon\ApiKeyAction::class) ;

};

