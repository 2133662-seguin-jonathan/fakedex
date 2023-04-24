<?php

use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // // Films
    // $app->get('/film', \App\Action\Film\FilmViewAction::class);

    // Ajouter un fakemon.
    $app->post('/fakemon', \App\Action\Fakemon\AjoutFakemonAction::class);

    // Donne la liste des fakemons
    $app->get('/fakemon', \App\Action\Fakemon\FakemonAction::class);

    // Donne la liste des types
    $app->get('/type', \App\Action\Fakemon\TypeAction::class);

    // Donne l'api key selon l'usager
    $app->post('/apikey', \App\Action\Fakemon\ApiKeyAction::class);

};

