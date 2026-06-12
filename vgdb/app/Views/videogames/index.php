<section class="container section">
    <div class="page-heading">
        <p class="eyebrow">Plataformas</p>
        <h1>Video Games</h1>
        <p>Conheca os consoles cadastrados no catalogo e veja quais jogos estao associados a cada plataforma.</p>
    </div>

    <?php if (!$videoGames): ?>
        <div class="empty-state">Nenhum Video Game cadastrado.</div>
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
                    <h2><?= e($videoGame['nome']) ?></h2>
                    <p><?= e($videoGame['descricao']) ?: 'Sem descricao cadastrada.' ?></p>
                    <a class="card-action" href="<?= base_url('/videogames/' . $videoGame['id']) ?>">Ver detalhes</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
