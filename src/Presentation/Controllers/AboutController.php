<?php

namespace App\Presentation\Controllers;

use App\Presentation\Request;

class AboutController
{
    public function index(Request $request, array $params = []): void
    {
        require BASE_PATH . '/views/about/index.php';
    }
}
