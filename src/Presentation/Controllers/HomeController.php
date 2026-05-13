<?php

namespace App\Presentation\Controllers;

use App\Infrastructure\Api\RickAndMortyClient;
use App\Presentation\Request;

class HomeController
{
    public function index(Request $request, array $params = []): void
    {
        require BASE_PATH . '/views/home/index.php';
    }

    public function apiCharacters(Request $request, array $params = []): void
    {
        header('Content-Type: application/json');

        $page   = max(1, (int) $request->get('page', 1));
        $name   = trim($request->get('name', ''));
        $status = trim($request->get('status', ''));

        $client = new RickAndMortyClient();
        $data   = $client->getCharacters($page, $name, $status);

        if ($data === null) {
            http_response_code(502);
            echo json_encode(['error' => 'Falha ao contatar a API.']);
            return;
        }

        echo json_encode($data);
    }
}
