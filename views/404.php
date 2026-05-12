<?php
$pageTitle  = 'Página não encontrada — RickVerse';
$activePage = '';

ob_start();
?>

<div class="container text-center py-5">
    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
    <h2 class="mt-3 fw-bold">Página não encontrada</h2>
    <p class="text-muted">O endereço que você acessou não existe ou foi removido.</p>
    <a href="/" class="btn btn-primary mt-2">
        <i class="bi bi-house me-2"></i>Voltar ao início
    </a>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
