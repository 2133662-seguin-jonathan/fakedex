<?php

namespace App\Action\Fakemon;

use App\Domain\Fakemon\Service\ApiKeyView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ApiKeyAction
{
    private $apiKeyview;

    public function __construct(ApiKeyView $apiKeyview)
    {
        $this->apiKeyview = $apiKeyview;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $status = 403;

        $queryParams = $request->getQueryParams() ?? [];
        $nouvelle = $queryParams["nouvelle"] ?? 0;

        $valeurAuth = $request->getHeaderLine("Authorization");
        if (explode(" ", $valeurAuth)[0] == "account") {
            $token = explode(" ", $valeurAuth)[1];
            if ( base64_encode(base64_decode($token, true)) === $token){
                $decodeToken = base64_decode($token);

                $data = [
                    "username" => explode(" ", $decodeToken)[0] ?? "",
                    "password" => explode(" ", $decodeToken)[1] ?? ""
                ];

                $resultat = $this->apiKeyview->getApiKey($data,$nouvelle);

                if ($resultat["api_key"] != "Compte invalide") {
                    $status = 200;
                }
                // Construit la réponse HTTP
                $response->getBody()->write((string)json_encode($resultat));
            }
        }        

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
