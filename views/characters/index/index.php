<?php
$pageTitle  = 'Meus Personagens — RickVerse';
$activePage = 'characters';

ob_start();
?>

<div class="container">
    <div class="text-center py-4 mb-4">
        <h1 class="display-5 fw-bold text-primary-custom">Meus Personagens</h1>
        <p class="text-muted lead">Personagens que você salvou localmente</p>
    </div>

    <?php if (empty($characters)): ?>
        <div class="text-center py-5">
            <i class="bi bi-bookmark-x text-muted" style="font-size: 3rem;"></i>
            <p class="mt-3 text-muted">Você ainda não salvou nenhum personagem.</p>
            <a href="/" class="btn btn-primary">
                <i class="bi bi-search me-2"></i>Explorar personagens
            </a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($characters as $char): ?>
                <div class="col">
                    <div class="card character-card h-100 border-0 shadow-sm"
                         onclick="location.href='/character/<?= $char->getId() ?>?source=local'">
                        <img src="<?= htmlspecialchars($char->getImage()) ?>"
                             alt="<?= htmlspecialchars($char->getName()) ?>"
                             loading="lazy">
                        <div class="card-body pb-1">
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($char->getName()) ?></h6>
                            <span class="text-muted small"><?= htmlspecialchars($char->getSpecies()) ?></span>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="/character/<?= $char->getId() ?>?source=local"
                               class="btn btn-primary btn-sm w-100">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
