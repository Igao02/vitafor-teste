<?php

namespace App\Infrastructure\Api;

class RickAndMortyClient
{
    private const BASE_URL = 'https://rickandmortyapi.com/api';

    public function getCharacter(int $id): ?array
    {
        $response = @file_get_contents(self::BASE_URL . '/character/' . $id);
        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);
        return is_array($data) && !isset($data['error']) ? $data : null;
    }
}
