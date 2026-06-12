<section class="container section detail-layout">
    <div class="detail-media">
        <?php if (!empty($jogo['capa'])): ?>
            <img src="<?= asset($jogo['capa']) ?>" alt="<?= e($jogo['titulo']) ?>">
        <?php else: ?>
            <div class="image-placeholder">Sem capa</div>
        <?php endif; ?>
    </div>

    <div class="detail-content">
        <p class="eyebrow"><?= e($jogo['genero']) ?></p>
        <h1><?= e($jogo['titulo']) ?></h1>
        <p><?= e($jogo['descricao']) ?></p>

        <dl class="meta-list">
            <div><dt>Desenvolvedora</dt><dd><?= e($jogo['desenvolvedora']) ?: '-' ?></dd></div>
            <div><dt>Publicadora</dt><dd><?= e($jogo['publicadora']) ?: '-' ?></dd></div>
            <div><dt>Ano</dt><dd><?= e($jogo['ano_lancamento']) ?></dd></div>
            <div><dt>Classificacao</dt><dd><?= e($jogo['classificacao_indicativa']) ?: '-' ?></dd></div>
            <div><dt>Modo</dt><dd><?= e($jogo['modo_jogo']) ?: '-' ?></dd></div>
        </dl>
    </div>
</section>

<section class="container section">
    <div class="section-title">
        <h2>Disponivel para</h2>
    </div>

    <div class="platform-list">
        <?php foreach ($jogo['plataformas'] as $platform): ?>
            <a href="<?= base_url('/videogames/' . $platform['id']) ?>"><?= e($platform['nome']) ?></a>
        <?php endforeach; ?>
    </div>
</section>
