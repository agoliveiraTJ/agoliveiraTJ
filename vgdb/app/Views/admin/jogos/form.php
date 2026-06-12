<?php
$isEdit = !empty($jogo['id']);
$action = $isEdit
    ? base_url('/admin/jogos/' . $jogo['id'] . '/atualizar')
    : base_url('/admin/jogos/salvar');
?>

<section class="container section">
    <div class="admin-header">
        <div>
            <p class="eyebrow">Admin</p>
            <h1><?= $isEdit ? 'Editar Jogo' : 'Novo Jogo' ?></h1>
        </div>
        <a class="btn btn-secondary" href="<?= base_url('/admin/jogos') ?>">Voltar</a>
    </div>

    <?php if ($errors): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form class="form-card" action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <label>
                Titulo *
                <input type="text" name="titulo" value="<?= e($jogo['titulo'] ?? '') ?>" required>
            </label>

            <label>
                Genero *
                <input type="text" name="genero" value="<?= e($jogo['genero'] ?? '') ?>" required>
            </label>

            <label>
                Desenvolvedora
                <input type="text" name="desenvolvedora" value="<?= e($jogo['desenvolvedora'] ?? '') ?>">
            </label>

            <label>
                Publicadora
                <input type="text" name="publicadora" value="<?= e($jogo['publicadora'] ?? '') ?>">
            </label>

            <label>
                Ano de lancamento *
                <input type="number" name="ano_lancamento" min="1970" max="2100" value="<?= e((string)($jogo['ano_lancamento'] ?? '')) ?>" required>
            </label>

            <label>
                Classificacao indicativa
                <input type="text" name="classificacao_indicativa" value="<?= e($jogo['classificacao_indicativa'] ?? '') ?>" placeholder="Livre, 10, 12, 14, 16, 18">
            </label>

            <label>
                Modo de jogo
                <input type="text" name="modo_jogo" value="<?= e($jogo['modo_jogo'] ?? '') ?>" placeholder="Single-player, Multiplayer, Online">
            </label>

            <label>
                Capa
                <input type="file" name="capa" accept=".jpg,.jpeg,.png,.webp">
            </label>
        </div>

        <?php if (!empty($jogo['capa'])): ?>
            <div class="current-image">
                <span>Capa atual</span>
                <img src="<?= asset($jogo['capa']) ?>" alt="<?= e($jogo['titulo']) ?>">
            </div>
        <?php endif; ?>

        <fieldset class="checkbox-group">
            <legend>Video Games *</legend>
            <?php foreach ($videoGames as $videoGame): ?>
                <label>
                    <input type="checkbox" name="video_games[]" value="<?= e((string)$videoGame['id']) ?>" <?= checked_array($selectedVideoGames, $videoGame['id']) ?>>
                    <?= e($videoGame['nome']) ?>
                </label>
            <?php endforeach; ?>
            <?php if (!$videoGames): ?>
                <p>Cadastre um Video Game antes de cadastrar jogos.</p>
            <?php endif; ?>
        </fieldset>

        <label>
            Descricao
            <textarea name="descricao" rows="5"><?= e($jogo['descricao'] ?? '') ?></textarea>
        </label>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
            <a class="btn btn-secondary" href="<?= base_url('/admin/jogos') ?>">Cancelar</a>
        </div>
    </form>
</section>
