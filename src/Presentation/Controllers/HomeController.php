<?php

namespace App\Presentation\Controllers;

use App\Presentation\Request;

class HomeController
{
    public function index(Request $request, array $params = []): void
    {
        require BASE_PATH . '/views/home/index.php';
    }
}
