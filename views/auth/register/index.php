<?php
$pageTitle  = 'Criar conta — RickVerse';
$activePage = 'register';

ob_start();
?>

<div class="container d-flex justify-content-center align-items-start py-5">
    <div class="card shadow-sm auth-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <span class="brand-icon-lg d-inline-flex align-items-center justify-content-center mb-3">
                    <i class="bi bi-person-plus fs-2"></i>
                </span>
                <h4 class="fw-bold mb-1">Criar conta</h4>
                <p class="text-muted small">Cadastre-se para salvar seus personagens favoritos</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/register" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label fw-medium">Nome completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Seu nome"
                            required
                            autocomplete="name"
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-medium">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="seu@email.com"
                            required
                            autocomplete="email"
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-medium">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Mínimo 6 caracteres"
                            required
                            autocomplete="new-password"
                        >
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password_confirm" class="form-label fw-medium">Confirmar senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input
                            type="password"
                            class="form-control"
                            id="password_confirm"
                            name="password_confirm"
                            placeholder="Repita a senha"
                            required
                            autocomplete="new-password"
                        >
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-person-check me-2"></i>Criar conta
                </button>
            </form>

            <p class="text-center text-muted small mt-4 mb-0">
                Já tem uma conta?
                <a href="/login" class="fw-semibold text-decoration-none">Entrar</a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
