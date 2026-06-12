<section class="container section">
    <div class="page-heading">
        <p class="eyebrow">Biblioteca</p>
        <h1>Jogos</h1>
        <p>Explore os jogos cadastrados, seus generos e as plataformas onde estao disponiveis.</p>
    </div>

    <?php if (!$jogos): ?>
        <div class="empty-state">Nenhum jogo cadastrado.</div>
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
                    <h2><?= e($jogo['titulo']) ?></h2>
                    <p><?= e($jogo['plataformas'] ?? 'Sem plataforma') ?></p>
                    <a class="card-action" href="<?= base_url('/jogos/' . $jogo['id']) ?>">Ver detalhes</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
