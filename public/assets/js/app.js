/* ── Toast helper ── */
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const id   = 'toast-' + Date.now();
    const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
    const bg   = type === 'success' ? 'bg-success' : 'bg-danger';

    container.insertAdjacentHTML('beforeend', `
        <div id="${id}" class="toast align-items-center text-white ${bg} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="bi ${icon}"></i> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `);

    const el    = document.getElementById(id);
    const toast = new bootstrap.Toast(el, { delay: 3500 });
    toast.show();
    el.addEventListener('hidden.bs.toast', () => el.remove());
}

/* ── Home page: Rick & Morty API ── */
const API_BASE = 'https://rickandmortyapi.com/api';

let currentPage   = 1;
let totalPages    = 1;
let searchTimeout = null;
let currentName   = '';
let currentStatus = '';

function initHomePage() {
    const searchInput  = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const clearBtn     = document.getElementById('clear-search');

    if (!searchInput) return;

    fetchCharacters(1);

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentName = searchInput.value.trim();
            fetchCharacters(1);
        }, 400);
    });

    statusFilter.addEventListener('change', () => {
        currentStatus = statusFilter.value;
        fetchCharacters(1);
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            currentName       = '';
            fetchCharacters(1);
        });
    }
}

async function fetchCharacters(page) {
    currentPage = page;
    showSkeletons();

    const params = new URLSearchParams({ page });
    if (currentName)   params.append('name', currentName);
    if (currentStatus) params.append('status', currentStatus);

    try {
        const res  = await fetch(`${API_BASE}/character?${params}`);
        const data = await res.json();

        if (!res.ok || data.error) {
            showEmptyState(currentName);
            return;
        }

        totalPages = data.info.pages;
        renderCards(data.results);
        updateCount(data.info.count, page, data.results.length);
        renderPagination(page, totalPages);
    } catch {
        showEmptyState(currentName);
    }
}

function renderCards(characters) {
    const grid = document.getElementById('characters-grid');
    document.getElementById('empty-state')?.classList.add('d-none');

    grid.innerHTML = characters.map(char => `
        <div class="col">
            <div class="card character-card h-100 border-0 shadow-sm"
                 onclick="location.href='/character/${char.id}?source=api'">
                <img src="${char.image}" alt="${escapeHtml(char.name)}" loading="lazy">
                <div class="card-body pb-1">
                    <h6 class="fw-bold mb-1">${escapeHtml(char.name)}</h6>
                    <span class="badge badge-${char.status.toLowerCase()} text-white small">
                        ${char.status}
                    </span>
                    <span class="text-muted small ms-1">${escapeHtml(char.species)}</span>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="/character/${char.id}?source=api" class="btn btn-primary btn-sm w-100">
                        Ver detalhes
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

function showSkeletons() {
    const grid = document.getElementById('characters-grid');
    document.getElementById('empty-state')?.classList.add('d-none');
    document.getElementById('results-count').textContent = '';

    grid.innerHTML = Array.from({ length: 8 }, () => `
        <div class="col">
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
    `).join('');

    ['pagination-top', 'pagination-bottom'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = '';
    });
}

function showEmptyState(query) {
    const grid  = document.getElementById('characters-grid');
    const empty = document.getElementById('empty-state');
    grid.innerHTML = '';
    if (empty) {
        document.getElementById('empty-query').textContent = query;
        empty.classList.remove('d-none');
    }
    ['pagination-top', 'pagination-bottom'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = '';
    });
}

function updateCount(total, page, shown) {
    const el = document.getElementById('results-count');
    if (el) el.textContent = `${total} personagens encontrados`;
}

function renderPagination(current, total) {
    if (total <= 1) return;

    const html = `
        <button class="btn btn-outline-primary btn-sm" onclick="fetchCharacters(${current - 1})"
            ${current === 1 ? 'disabled' : ''}>
            <i class="bi bi-chevron-left"></i> Anterior
        </button>
        <span class="btn btn-sm disabled text-muted">
            ${current} / ${total}
        </span>
        <button class="btn btn-outline-primary btn-sm" onclick="fetchCharacters(${current + 1})"
            ${current === total ? 'disabled' : ''}>
            Próxima <i class="bi bi-chevron-right"></i>
        </button>
    `;

    ['pagination-top', 'pagination-bottom'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    });
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

/* ── Detail page ── */
function initDetailPage() {
    const btnSave     = document.getElementById('btn-save');
    const btnSaveEdit = document.getElementById('btn-save-edit');
    const btnDelete   = document.getElementById('btn-delete');
    const editForm    = document.getElementById('edit-form');

    if (btnSave) {
        btnSave.addEventListener('click', async () => {
            btnSave.disabled = true;
            btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Salvando...';

            const data = {
                api_id:   btnSave.dataset.apiId,
                name:     btnSave.dataset.name,
                species:  btnSave.dataset.species,
                gender:   btnSave.dataset.gender,
                location: btnSave.dataset.location,
                image:    btnSave.dataset.image,
                url:      btnSave.dataset.url,
            };

            try {
                const res = await fetch('/api/characters', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body:    JSON.stringify(data),
                });
                const json = await res.json();
                if (json.success) {
                    showToast('Personagem salvo com sucesso!');
                    btnSave.innerHTML = '<i class="bi bi-bookmark-check me-2"></i>Salvo!';
                } else {
                    throw new Error(json.error);
                }
            } catch (e) {
                showToast(e.message || 'Erro ao salvar.', 'error');
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="bi bi-bookmark-plus me-2"></i>Salvar personagem';
            }
        });
    }

    if (btnSaveEdit && editForm) {
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const id   = btnSaveEdit.dataset.id;
            const data = Object.fromEntries(new FormData(editForm));

            btnSaveEdit.disabled = true;
            btnSaveEdit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Salvando...';

            try {
                const res = await fetch(`/api/characters/${id}`, {
                    method:  'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body:    JSON.stringify(data),
                });
                const json = await res.json();
                if (json.success) {
                    showToast('Alterações salvas!');
                } else {
                    throw new Error(json.error);
                }
            } catch (e) {
                showToast(e.message || 'Erro ao salvar.', 'error');
            } finally {
                btnSaveEdit.disabled = false;
                btnSaveEdit.innerHTML = '<i class="bi bi-check-lg me-1"></i>Salvar alterações';
            }
        });
    }

    if (btnDelete) {
        btnDelete.addEventListener('click', async () => {
            if (!confirm('Tem certeza que quer excluir este personagem?')) return;
            const id = btnDelete.dataset.id;

            try {
                const res = await fetch(`/api/characters/${id}`, { method: 'DELETE' });
                const json = await res.json();
                if (json.success) {
                    showToast('Personagem excluído.');
                    setTimeout(() => location.href = '/characters', 1200);
                } else {
                    throw new Error(json.error);
                }
            } catch (e) {
                showToast(e.message || 'Erro ao excluir.', 'error');
            }
        });
    }
}
