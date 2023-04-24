<?php

use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // // Films
    // $app->get('/film', \App\Action\Film\FilmViewAction::class);

    // Donne la liste des fakemons
    $app->get('/fakemon', \App\Action\Film\FilmViewAction::class);

    // Donne l'api key selon l'usager
    $app->post('/apikey', \App\Action\Fakemon\ApiKeyAction::class);

};

