<section class="container section">
    <div class="admin-header">
        <div>
            <p class="eyebrow">Administracao</p>
            <h1>Painel Administrativo</h1>
            <p>Gerencie os cadastros de Video Games e Jogos.</p>
        </div>
    </div>

    <div class="admin-actions">
        <a class="btn btn-primary" href="<?= base_url('/admin/videogames/novo') ?>">Cadastrar Video Game</a>
        <a class="btn btn-primary" href="<?= base_url('/admin/jogos/novo') ?>">Cadastrar Jogo</a>
    </div>

    <div class="stats-grid">
        <article class="stat-card">
            <span>Video Games</span>
            <strong><?= e((string)$totalVideoGames) ?></strong>
            <a href="<?= base_url('/admin/videogames') ?>">Gerenciar</a>
        </article>
        <article class="stat-card">
            <span>Jogos</span>
            <strong><?= e((string)$totalJogos) ?></strong>
            <a href="<?= base_url('/admin/jogos') ?>">Gerenciar</a>
        </article>
    </div>
</section>
