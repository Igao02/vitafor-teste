<?php

namespace App\Presentation\Controllers;

use App\Application\AuthService;
use App\Application\CharacterService;
use App\Infrastructure\Api\RickAndMortyClient;
use App\Infrastructure\Repositories\CharacterRepository;
use App\Presentation\Request;

class CharacterController
{
    private CharacterService $service;
    private CharacterRepository $repo;

    public function __construct()
    {
        $this->repo    = new CharacterRepository();
        $this->service = new CharacterService($this->repo);
    }

    public function index(Request $request, array $params = []): void
    {
        if (!AuthService::check()) {
            header('Location: /login');
            exit;
        }

        $characters = $this->repo->findByUserId(AuthService::id());
        require BASE_PATH . '/views/characters/index/index.php';
    }

    public function show(Request $request, array $params = []): void
    {
        $source = $request->get('source', 'api');
        $id     = (int) ($params['id'] ?? 0);

        if ($source === 'local') {
            $character = $this->repo->findById($id);
            if (!$character) {
                http_response_code(404);
                require BASE_PATH . '/views/404.php';
                return;
            }
            require BASE_PATH . '/views/characters/show/index.php';
            return;
        }

        $client    = new RickAndMortyClient();
        $character = $client->getCharacter($id);
        if (!$character) {
            http_response_code(404);
            require BASE_PATH . '/views/404.php';
            return;
        }

        $savedLocalId = AuthService::check()
            ? $this->repo->findIdByApiId(AuthService::id(), $id)
            : null;

        require BASE_PATH . '/views/characters/show/index.php';
    }

    public function store(Request $request, array $params = []): void
    {
        header('Content-Type: application/json');

        if (!AuthService::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autenticado.']);
            return;
        }

        $data      = $request->json();
        $character = $this->service->save(AuthService::id(), $data);

        echo json_encode(['success' => true, 'id' => $character->getId()]);
    }

    public function update(Request $request, array $params = []): void
    {
        header('Content-Type: application/json');

        if (!AuthService::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autenticado.']);
            return;
        }

        $id        = (int) ($params['id'] ?? 0);
        $data      = $request->json();
        $character = $this->service->update($id, AuthService::id(), $data);

        if (!$character) {
            http_response_code(404);
            echo json_encode(['error' => 'Personagem não encontrado.']);
            return;
        }

        echo json_encode(['success' => true]);
    }

    public function destroy(Request $request, array $params = []): void
    {
        header('Content-Type: application/json');

        if (!AuthService::check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Não autenticado.']);
            return;
        }

        $id      = (int) ($params['id'] ?? 0);
        $deleted = $this->service->delete($id, AuthService::id());

        if (!$deleted) {
            http_response_code(404);
            echo json_encode(['error' => 'Personagem não encontrado.']);
            return;
        }

        echo json_encode(['success' => true]);
    }
}
