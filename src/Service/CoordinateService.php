<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class CoordinateService
{
    public function getCoordinates(string $city): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api-adresse.data.gouv.fr/search/?q='.$city);
        $content = $response->toArray();
        $coordinates = $content['features'][0]['geometry']['coordinates'];
        return $coordinates;
    }
}
