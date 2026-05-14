<?php
$pageTitle  = 'Sobre — RickVerse';
$activePage = 'about';

ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-7">

            <div class="card border-0 shadow-sm p-4 mb-4 text-center">
                <div class="mb-3">
                    <img src="/assets/img/igor_foto.jpg"
                         alt="Igor Abiézer"
                         class="rounded-circle shadow"
                         width="110" height="110"
                         style="object-fit: cover;">
                </div>
                <h2 class="fw-bold mb-1">Igor Abiézer Lima de Oliveira</h2>
                <p class="text-primary-custom fw-semibold mb-1">Desenvolvedor Full Stack Júnior</p>
                <p class="text-muted small mb-3">
                    <i class="bi bi-geo-alt me-1"></i>Sorocaba, SP
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://github.com/Igao02" target="_blank" rel="noopener"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-github me-1"></i>GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/igor-abiezer-a83a58216" target="_blank" rel="noopener"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-linkedin me-1"></i>LinkedIn
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3 text-primary-custom">
                    <i class="bi bi-person-lines-fill me-2"></i>Sobre mim
                </h5>
                <p class="text-muted mb-0">
                    Desenvolvedor Full Stack Júnior formado em Análise e Desenvolvimento de Sistemas
                    pela <strong>Fatec Sorocaba</strong>, com experiência prática em construção de aplicações
                    web utilizando Node.js, React e .NET. Atuo com front-end e back-end, tenho facilidade em
                    adaptar tecnologias conforme a necessidade do projeto e busco oportunidade para
                    crescer em equipes ágeis, contribuindo com qualidade, entrega e aprendizado contínuo.
                </p>
            </div>

            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3 text-primary-custom">
                    <i class="bi bi-tools me-2"></i>Habilidades
                </h5>

                <div class="mb-3">
                    <p class="skill-category">Back-end</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach (['Node.js', 'Express', 'C#', 'ASP.NET Core', 'REST APIs', 'Entity Framework'] as $s): ?>
                            <span class="skill-badge"><?= $s ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="skill-category">Front-end</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach (['React', 'TypeScript', 'JavaScript', 'Blazor', 'HTML5', 'CSS3'] as $s): ?>
                            <span class="skill-badge"><?= $s ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="skill-category">Banco de dados</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach (['SQL Server', 'PostgreSQL'] as $s): ?>
                            <span class="skill-badge"><?= $s ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <p class="skill-category">Cloud & Infra</p>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach (['Azure', 'Git'] as $s): ?>
                            <span class="skill-badge"><?= $s ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Projetos -->
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3 text-primary-custom">
                    <i class="bi bi-code-slash me-2"></i>Projetos
                </h5>
                <div class="row g-3">

                    <div class="col-12 col-sm-6">
                        <div class="about-project-card h-100 p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-1">Tá Marcado</h6>
                            <p class="text-muted small mb-2">
                                SaaS de agendamento para profissionais autônomos como barbeiros,
                                manicures e outros prestadores de serviço.
                            </p>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <?php foreach (['ASP.NET Core', 'MudBlazor', 'SQL Server'] as $s): ?>
                                    <span class="skill-badge" style="font-size:.7rem"><?= $s ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="https://github.com/Igao02/TaMarcado" target="_blank" rel="noopener"
                               class="btn btn-outline-primary btn-sm mt-auto">
                                <i class="bi bi-github me-1"></i>Ver no GitHub
                            </a>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="about-project-card h-100 p-3 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0">Falando Sobre</h6>
                                <span class="badge bg-secondary" style="font-size:.65rem">TCC · Fatec</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Rede social para expor e relatar atos de discriminação racial,
                                feminicídio e contra o grupo LGBT de forma segura.
                            </p>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <?php foreach (['C#', 'ASP.NET Core', 'Blazor', 'SQL Server'] as $s): ?>
                                    <span class="skill-badge" style="font-size:.7rem"><?= $s ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="https://github.com/Igao02/FalandoSobre" target="_blank" rel="noopener"
                               class="btn btn-outline-primary btn-sm mt-auto">
                                <i class="bi bi-github me-1"></i>Ver no GitHub
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
