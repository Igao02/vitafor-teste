<?php
$pageTitle  = 'RickVerse — Explorar Personagens';
$activePage = 'home';

ob_start();
?>

<div class="container">
    <div class="text-center py-4 mb-4">
        <h1 class="display-5 fw-bold text-primary-custom">Explorar Personagens</h1>
        <p class="text-muted lead">Descubra todos os personagens do universo de Rick and Morty</p>
    </div>

    <!-- Search + filter -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input
                    type="text"
                    id="search-input"
                    class="form-control border-start-0 ps-0"
                    placeholder="Buscar personagem..."
                    autocomplete="off"
                >
                <select id="status-filter" class="form-select" style="max-width: 140px;">
                    <option value="">Todos</option>
                    <option value="alive">Vivo</option>
                    <option value="dead">Morto</option>
                    <option value="unknown">Desconhecido</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Info + paginação topo -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted small mb-0" id="results-count"></p>
        <div id="pagination-top" class="d-flex gap-2"></div>
    </div>

    <!-- Grid de cards -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="characters-grid">
        <?php for ($i = 0; $i < 8; $i++): ?>
            <div class="col skeleton-col">
                <div class="card character-card h-100 border-0 shadow-sm">
                    <div class="skeleton-img skeleton"></div>
                    <div class="card-body">
                        <div class="skeleton skeleton-text mb-2"></div>
                        <div class="skeleton skeleton-text-sm"></div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <div class="skeleton skeleton-btn"></div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Paginação base -->
    <div class="d-flex justify-content-center gap-2 mt-5" id="pagination-bottom"></div>

    <!-- Estado vazio (busca sem resultado) -->
    <div class="text-center py-5 d-none" id="empty-state">
        <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
        <p class="mt-3 text-muted">Nenhum personagem encontrado para "<span id="empty-query"></span>"</p>
        <button class="btn btn-outline-primary btn-sm" id="clear-search">Limpar busca</button>
    </div>

    <!-- Erro de API -->
    <div class="text-center py-5 d-none" id="api-error-state">
        <i class="bi bi-wifi-off text-muted" style="font-size: 3rem;"></i>
        <p class="mt-3 text-muted fw-semibold">Sem retorno da API</p>
        <p class="text-muted small">A API do Rick and Morty não respondeu. Tente novamente em instantes.</p>
        <button class="btn btn-outline-primary btn-sm" onclick="fetchCharacters(currentPage)">
            <i class="bi bi-arrow-clockwise me-1"></i>Tentar novamente
        </button>
    </div>
</div>

<?php
$content = ob_get_clean();

$extraJs = <<<JS
<script>
    document.addEventListener('DOMContentLoaded', () => initHomePage());
</script>
JS;

require BASE_PATH . '/views/layouts/main.php';
