<section class="container section detail-layout">
    <div class="detail-media">
        <?php if (!empty($videoGame['imagem'])): ?>
            <img src="<?= asset($videoGame['imagem']) ?>" alt="<?= e($videoGame['nome']) ?>">
        <?php else: ?>
            <div class="image-placeholder">Sem imagem</div>
        <?php endif; ?>
    </div>

    <div class="detail-content">
        <p class="eyebrow"><?= e($videoGame['fabricante']) ?></p>
        <h1><?= e($videoGame['nome']) ?></h1>
        <p><?= e($videoGame['descricao']) ?></p>

        <dl class="meta-list">
            <div><dt>Geracao</dt><dd><?= e($videoGame['geracao']) ?: '-' ?></dd></div>
            <div><dt>Ano</dt><dd><?= e($videoGame['ano_lancamento']) ?></dd></div>
            <div><dt>Midia</dt><dd><?= e($videoGame['midia']) ?: '-' ?></dd></div>
        </dl>
    </div>
</section>

<section class="container section">
    <div class="section-title">
        <h2>Jogos relacionados</h2>
    </div>

    <?php if (!$jogos): ?>
        <div class="empty-state">Nenhum jogo relacionado a este Video Game.</div>
    <?php endif; ?>

    <div class="card-grid">
        <?php foreach ($jogos as $jogo): ?>
            <article class="item-card">
                <?php if (!empty($jogo['capa'])): ?>
                    <img src="<?= asset($jogo['capa']) ?>" alt="<?= e($jogo['titulo']) ?>">
                <?php endif; ?>
                <div class="item-card-body">
                    <span><?= e($jogo['genero']) ?></span>
                    <h3><?= e($jogo['titulo']) ?></h3>
                    <a href="<?= base_url('/jogos/' . $jogo['id']) ?>">Ver jogo</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
