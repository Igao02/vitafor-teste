<?php
$pageTitle  = 'Entrar — RickVerse';
$activePage = 'login';

ob_start();
?>

<div class="container d-flex justify-content-center align-items-start py-5">
    <div class="card shadow-sm auth-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <span class="brand-icon-lg d-inline-flex align-items-center justify-content-center mb-3">
                    <i class="bi bi-globe2 fs-2"></i>
                </span>
                <h4 class="fw-bold mb-1">Bem-vindo de volta</h4>
                <p class="text-muted small">Entre na sua conta para salvar personagens</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login" novalidate>
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
                <div class="mb-4">
                    <label for="password" class="form-label fw-medium">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </button>
            </form>

            <p class="text-center text-muted small mt-4 mb-0">
                Não tem uma conta?
                <a href="/register" class="fw-semibold text-decoration-none">Cadastrar-se</a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
