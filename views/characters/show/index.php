<?php
use App\Application\AuthService;
use App\Domain\Character;

$source    = $_GET['source'] ?? 'api';
$isLocal   = $source === 'local';
$isLoggedIn = AuthService::check();

if ($isLocal && $character instanceof Character) {
    $name      = $character->getName();
    $species   = $character->getSpecies();
    $image     = $character->getImage();
    $url       = $character->getUrl();
    $charId    = $character->getId();
    $createdAt = $character->getCreatedAt();
    $updatedAt = $character->getUpdatedAt();

    $fmtDate = fn(string $d): string =>
        $d ? date('d/m/Y H:i', strtotime($d)) : '—';
} else {
    $name     = $character['name']             ?? '';
    $species  = $character['species']          ?? '';
    $gender   = $character['gender']           ?? '';
    $location = $character['location']['name'] ?? '';
    $image    = $character['image']            ?? '';
    $url      = $character['url']              ?? '';
    $charId   = $character['id']               ?? 0;
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
            <div class="row align-items-start g-4">

                <!-- Imagem circular -->
                <div class="col-12 col-md-4 text-center pt-2">
                    <img src="<?= htmlspecialchars($image) ?>"
                         alt="<?= htmlspecialchars($name) ?>"
                         class="detail-image img-fluid">
                </div>

                <!-- Dados -->
                <div class="col-12 col-md-8 d-flex flex-column">

                    <?php if ($isLocal): ?>
                        <!-- Modo local: editar campos salvos -->
                        <h2 class="fw-bold mb-4"><?= htmlspecialchars($name) ?></h2>

                        <form id="edit-form" class="flex-grow-1">
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold">Nome</label>
                                    <input type="text" class="form-control" name="name"
                                           value="<?= htmlspecialchars($name) ?>">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold">Espécie</label>
                                    <input type="text" class="form-control" name="species"
                                           value="<?= htmlspecialchars($species) ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Imagem (URL)</label>
                                <input type="text" class="form-control" name="image"
                                       value="<?= htmlspecialchars($image) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">URL</label>
                                <input type="text" class="form-control" name="url"
                                       value="<?= htmlspecialchars($url) ?>">
                            </div>

                            <!-- Datas (somente leitura) -->
                            <div class="row g-3 mb-4 text-muted small">
                                <div class="col-6">
                                    <span class="fw-semibold d-block">Criado em</span>
                                    <?= htmlspecialchars($fmtDate($createdAt)) ?>
                                </div>
                                <div class="col-6">
                                    <span class="fw-semibold d-block">Atualizado em</span>
                                    <?= htmlspecialchars($fmtDate($updatedAt)) ?>
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-outline-danger" id="btn-delete"
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
                        <!-- Modo API: visualizar dados da API -->
                        <h2 class="fw-bold mb-4"><?= htmlspecialchars($name) ?></h2>

                        <dl class="row mb-4 flex-grow-1">
                            <dt class="col-sm-4 text-muted">Espécie</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($species) ?></dd>

                            <dt class="col-sm-4 text-muted">Gênero</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($gender) ?></dd>

                            <dt class="col-sm-4 text-muted">Localização</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($location) ?></dd>

                            <dt class="col-sm-4 text-muted">URL</dt>
                            <dd class="col-sm-8">
                                <a href="<?= htmlspecialchars($url) ?>" target="_blank"
                                   rel="noopener" class="text-decoration-none small text-break">
                                    <?= htmlspecialchars($url) ?>
                                </a>
                            </dd>
                        </dl>

                        <div class="d-flex justify-content-end">
                            <?php if ($isLoggedIn && ($savedLocalId ?? null)): ?>
                                <a href="/character/<?= $savedLocalId ?>?source=local"
                                   class="btn btn-success">
                                    <i class="bi bi-bookmark-check me-2"></i>Ver personagem salvo
                                </a>
                            <?php elseif ($isLoggedIn): ?>
                                <button class="btn btn-primary" id="btn-save"
                                        data-api-id="<?= $charId ?>"
                                        data-name="<?= htmlspecialchars($name) ?>"
                                        data-species="<?= htmlspecialchars($species) ?>"
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
