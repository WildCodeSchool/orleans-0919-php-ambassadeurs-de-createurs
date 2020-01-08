<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class CoordinateService
{
    public function getCoordinates(string $city): ?array
    {
        $client = HttpClient::create();
        $url = 'https://api-adresse.data.gouv.fr/search/?q='.$city.'&type=municipality';
        $response = $client->request('GET', $url);
        $content = $response->toArray();
        $coordinates = $content['features'][0]['geometry']['coordinates'] ?? null;
        return $coordinates;
    }
}
