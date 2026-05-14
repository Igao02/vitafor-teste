<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'RickVerse') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" id="main-nav">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span class="nav-logo">R&M</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item">
                    <a class="nav-btn <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-btn <?= ($activePage ?? '') === 'characters' ? 'active' : '' ?>" href="/characters">Personagens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-btn <?= ($activePage ?? '') === 'about' ? 'active' : '' ?>" href="/about">Sobre</a>
                </li>
                <?php if (\App\Application\AuthService::check()): ?>
                    <li class="nav-item">
                        <a class="nav-btn <?= ($activePage ?? '') === 'logout' ? 'active' : '' ?>" href="/logout">Sair</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-btn <?= in_array($activePage ?? '', ['login','register']) ? 'active' : '' ?>" href="/login">Login/Cadastro</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <?= $content ?? '' ?>
</main>

<footer class="text-center text-muted py-4 border-top small">
    <div class="container">
        Desenvolvido usando a
        <a href="https://rickandmortyapi.com" target="_blank" class="text-decoration-none">Rick and Morty API</a>
    </div>
</footer>

<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
<?= $extraJs ?? '' ?>
</body>
</html>
