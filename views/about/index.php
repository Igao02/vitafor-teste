<?php
$pageTitle  = 'Sobre — RickVerse';
$activePage = 'about';

ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="mb-4">
                <img
                    src="https://github.com/igorbiez08.png"
                    alt="Foto de perfil"
                    class="rounded-circle shadow"
                    width="120"
                    height="120"
                    onerror="this.src='https://ui-avatars.com/api/?name=Igor&background=1a3a5c&color=fff&size=120'"
                >
            </div>
            <h2 class="fw-bold">Igor</h2>
            <p class="text-muted">Desenvolvedor PHP &bull; Em breve mais informações</p>

            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="#" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-github me-1"></i>GitHub
                </a>
                <a href="#" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-linkedin me-1"></i>LinkedIn
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
