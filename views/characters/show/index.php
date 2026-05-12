<?php
use App\Application\AuthService;
use App\Domain\Character;

$source    = $_GET['source'] ?? 'api';
$isLocal   = $source === 'local';
$isLoggedIn = AuthService::check();

if ($isLocal && $character instanceof Character) {
    $name     = $character->getName();
    $species  = $character->getSpecies();
    $gender   = $character->getGender();
    $location = $character->getLocation();
    $image    = $character->getImage();
    $url      = $character->getUrl();
    $charId   = $character->getId();
} else {
    $name     = $character['name']              ?? '';
    $species  = $character['species']           ?? '';
    $gender   = $character['gender']            ?? '';
    $location = $character['location']['name']  ?? '';
    $image    = $character['image']             ?? '';
    $url      = $character['url']               ?? '';
    $charId   = $character['id']                ?? 0;
}

$pageTitle  = htmlspecialchars($name) . ' — RickVerse';
$activePage = $isLocal ? 'characters' : 'home';

ob_start();
?>

<div class="container py-4">
    <a href="<?= $isLocal ? '/characters' : '/' ?>" class="btn btn-sm btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left me-1"></i><?= $isLocal ? 'Voltar aos meus personagens' : 'Voltar ao início' ?>
    </a>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row align-items-center g-4">
                <!-- Imagem -->
                <div class="col-12 col-md-4 text-center">
                    <img src="<?= htmlspecialchars($image) ?>"
                         alt="<?= htmlspecialchars($name) ?>"
                         class="detail-image img-fluid">
                </div>

                <!-- Dados -->
                <div class="col-12 col-md-8">
                    <?php if ($isLocal): ?>
                        <!-- Modo edição -->
                        <form id="edit-form">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nome</label>
                                <input type="text" class="form-control" name="name"
                                       value="<?= htmlspecialchars($name) ?>">
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold">Espécie</label>
                                    <input type="text" class="form-control" name="species"
                                           value="<?= htmlspecialchars($species) ?>">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold">Gênero</label>
                                    <input type="text" class="form-control" name="gender"
                                           value="<?= htmlspecialchars($gender) ?>">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-4">
                                    <label class="form-label fw-semibold">Localização</label>
                                    <input type="text" class="form-control" name="location"
                                           value="<?= htmlspecialchars($location) ?>">
                                </div>
                                <div class="col-12 col-sm-4">
                                    <label class="form-label fw-semibold">Imagem (URL)</label>
                                    <input type="text" class="form-control" name="image"
                                           value="<?= htmlspecialchars($image) ?>">
                                </div>
                                <div class="col-12 col-sm-4">
                                    <label class="form-label fw-semibold">URL</label>
                                    <input type="text" class="form-control" name="url"
                                           value="<?= htmlspecialchars($url) ?>">
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-danger" id="btn-delete"
                                        data-id="<?= $charId ?>">
                                    <i class="bi bi-trash me-1"></i>Excluir
                                </button>
                                <button type="submit" class="btn btn-primary" id="btn-save-edit"
                                        data-id="<?= $charId ?>">
                                    <i class="bi bi-check-lg me-1"></i>Salvar alterações
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- Modo visualização (API) -->
                        <h2 class="fw-bold mb-3"><?= htmlspecialchars($name) ?></h2>
                        <dl class="row mb-4">
                            <dt class="col-sm-4 text-muted">Espécie</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($species) ?></dd>

                            <dt class="col-sm-4 text-muted">Gênero</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($gender) ?></dd>

                            <dt class="col-sm-4 text-muted">Localização</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($location) ?></dd>

                            <dt class="col-sm-4 text-muted">URL na API</dt>
                            <dd class="col-sm-8">
                                <a href="<?= htmlspecialchars($url) ?>" target="_blank"
                                   class="text-decoration-none small">
                                    <?= htmlspecialchars($url) ?>
                                </a>
                            </dd>
                        </dl>

                        <div class="d-flex justify-content-end">
                            <?php if ($isLoggedIn): ?>
                                <button class="btn btn-primary" id="btn-save"
                                        data-api-id="<?= $charId ?>"
                                        data-name="<?= htmlspecialchars($name) ?>"
                                        data-species="<?= htmlspecialchars($species) ?>"
                                        data-gender="<?= htmlspecialchars($gender) ?>"
                                        data-location="<?= htmlspecialchars($location) ?>"
                                        data-image="<?= htmlspecialchars($image) ?>"
                                        data-url="<?= htmlspecialchars($url) ?>">
                                    <i class="bi bi-bookmark-plus me-2"></i>Salvar personagem
                                </button>
                            <?php else: ?>
                                <a href="/login" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Entre para salvar este personagem
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extraJs = <<<JS
<script>
    document.addEventListener('DOMContentLoaded', () => initDetailPage());
</script>
JS;

require BASE_PATH . '/views/layouts/main.php';
