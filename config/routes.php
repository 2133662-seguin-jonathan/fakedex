<?php

use Slim\App;

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
    $app->post('/fakemon', \App\Action\Fakemon\AjoutFakemonAction::class);

    // Modifier un fakemon.
    $app->put('/fakemon/{id}', \App\Action\Fakemon\UpdateFakemonAction::class);

    // Supprimer un fakemon.
    $app->delete('/fakemon/{id}', \App\Action\Fakemon\DeleteFakemonAction::class);

    // Donne la liste des fakemons
    $app->get('/fakemon', \App\Action\Fakemon\FakemonAction::class);

    // Donne la liste des types
    $app->get('/type', \App\Action\Fakemon\TypeAction::class);

    // Donne l'api key selon l'usager
    $app->get('/apikey', \App\Action\Fakemon\ApiKeyAction::class);

    base64_encode("admin fakemon");

};

