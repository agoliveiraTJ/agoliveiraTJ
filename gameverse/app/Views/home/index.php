<section class="hero">
    <div class="container hero-content">
        <div class="hero-copy">
            <p class="eyebrow">Catalogo gamer em PHP MVC</p>
            <h1>Seu hub para organizar consoles, plataformas e jogos.</h1>
            <p>Cadastre Video Games, relacione jogos a varias plataformas e consulte tudo em uma interface rapida, responsiva e facil de navegar.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= base_url('/admin') ?>">Acessar admin</a>
                <a class="btn btn-secondary" href="<?= base_url('/jogos') ?>">Ver jogos</a>
            </div>
        </div>

        <div class="hero-panel" aria-hidden="true">
            <div class="controller-visual">
                <span class="stick stick-left"></span>
                <span class="stick stick-right"></span>
                <span class="dpad"></span>
                <span class="button button-a"></span>
                <span class="button button-b"></span>
                <span class="button button-x"></span>
                <span class="button button-y"></span>
            </div>
            <div class="hero-stats">
                <div><strong><?= count($videoGames) ?></strong><span>Consoles recentes</span></div>
                <div><strong><?= count($jogos) ?></strong><span>Jogos recentes</span></div>
            </div>
        </div>
    </div>
</section>

<section class="container section">
    <div class="section-title">
        <div>
            <p class="eyebrow">Recentes</p>
            <h2>Video Games cadastrados</h2>
        </div>
        <a class="section-link" href="<?= base_url('/videogames') ?>">Ver todos</a>
    </div>

    <?php if (!$videoGames): ?>
        <div class="empty-state">Nenhum Video Game cadastrado ainda.</div>
    <?php endif; ?>

    <div class="card-grid">
        <?php foreach ($videoGames as $videoGame): ?>
            <article class="item-card">
                <?php if (!empty($videoGame['imagem'])): ?>
                    <img src="<?= asset($videoGame['imagem']) ?>" alt="<?= e($videoGame['nome']) ?>">
                <?php else: ?>
                    <div class="card-media-placeholder"><span>Console</span></div>
                <?php endif; ?>
                <div class="item-card-body">
                    <span><?= e($videoGame['fabricante']) ?></span>
                    <h3><?= e($videoGame['nome']) ?></h3>
                    <p><?= e($videoGame['ano_lancamento']) ?> <?= $videoGame['geracao'] ? '- ' . e($videoGame['geracao']) : '' ?></p>
                    <a class="card-action" href="<?= base_url('/videogames/' . $videoGame['id']) ?>">Detalhes</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="container section section-tight">
    <div class="section-title">
        <div>
            <p class="eyebrow">Biblioteca</p>
            <h2>Jogos recentes</h2>
        </div>
        <a class="section-link" href="<?= base_url('/jogos') ?>">Ver todos</a>
    </div>

    <?php if (!$jogos): ?>
        <div class="empty-state">Nenhum jogo cadastrado ainda.</div>
    <?php endif; ?>

    <div class="card-grid">
        <?php foreach ($jogos as $jogo): ?>
            <article class="item-card">
                <?php if (!empty($jogo['capa'])): ?>
                    <img src="<?= asset($jogo['capa']) ?>" alt="<?= e($jogo['titulo']) ?>">
                <?php else: ?>
                    <div class="card-media-placeholder"><span>Jogo</span></div>
                <?php endif; ?>
                <div class="item-card-body">
                    <span><?= e($jogo['genero']) ?></span>
                    <h3><?= e($jogo['titulo']) ?></h3>
                    <p><?= e($jogo['ano_lancamento']) ?> <?= $jogo['modo_jogo'] ? '- ' . e($jogo['modo_jogo']) : '' ?></p>
                    <a class="card-action" href="<?= base_url('/jogos/' . $jogo['id']) ?>">Detalhes</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
