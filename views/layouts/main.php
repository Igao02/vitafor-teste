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
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <span class="brand-icon"><i class="bi bi-globe2"></i></span>
            <span class="fw-bold">RickVerse</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activePage ?? '') === 'characters' ? 'active' : '' ?>" href="/characters">Personagens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activePage ?? '') === 'about' ? 'active' : '' ?>" href="/about">Sobre</a>
                </li>
                <?php if (\App\Application\AuthService::check()): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white-50">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(\App\Application\AuthService::name()) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-nav-logout" href="/logout">
                            <i class="bi bi-box-arrow-right me-1"></i>Sair
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage ?? '') === 'login' ? 'active' : '' ?>" href="/login">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-nav-register <?= ($activePage ?? '') === 'register' ? 'active' : '' ?>" href="/register">Cadastrar</a>
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
        Desenvolvido com <i class="bi bi-heart-fill text-danger"></i> usando a
        <a href="https://rickandmortyapi.com" target="_blank" class="text-decoration-none">Rick and Morty API</a>
    </div>
</footer>

<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
<?= $extraJs ?? '' ?>
</body>
</html>
