<?php

namespace App\Infrastructure\Api;

class RickAndMortyClient
{
    private const BASE_URL = 'https://rickandmortyapi.com/api';

    private const MAX_RETRY  = 5;
    private const RETRY_WAIT = 2000000; // 2s em microsegundos

    private function get(string $url): ?array
    {
        for ($attempt = 1; $attempt <= self::MAX_RETRY; $attempt++) {
            $ch = \curl_init($url);
            \curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_USERAGENT      => 'RickVerse/1.0',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = \curl_exec($ch);
            $httpCode = \curl_getinfo($ch, CURLINFO_HTTP_CODE);
            \curl_close($ch);

            if ($response !== false && $httpCode === 200) {
                $data = json_decode($response, true);
                return (is_array($data) && !isset($data['error'])) ? $data : null;
            }

            if ($httpCode === 429 && $attempt < self::MAX_RETRY) {
                usleep(self::RETRY_WAIT * $attempt);
                continue;
            }

            return null;
        }
    }

    public function getCharacters(int $page = 1, string $name = '', string $status = ''): ?array
    {
        $params = ['page' => $page];
        if ($name   !== '') $params['name']   = $name;
        if ($status !== '') $params['status'] = $status;

        return $this->get(self::BASE_URL . '/character?' . http_build_query($params));
    }

    public function getCharacter(int $id): ?array
    {
        return $this->get(self::BASE_URL . '/character/' . $id);
    }
}
