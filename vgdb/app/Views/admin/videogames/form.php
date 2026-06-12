<?php
$isEdit = !empty($videoGame['id']);
$action = $isEdit
    ? base_url('/admin/videogames/' . $videoGame['id'] . '/atualizar')
    : base_url('/admin/videogames/salvar');
?>

<section class="container section">
    <div class="admin-header">
        <div>
            <p class="eyebrow">Admin</p>
            <h1><?= $isEdit ? 'Editar Video Game' : 'Novo Video Game' ?></h1>
        </div>
        <a class="btn btn-secondary" href="<?= base_url('/admin/videogames') ?>">Voltar</a>
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
                Nome *
                <input type="text" name="nome" value="<?= e($videoGame['nome'] ?? '') ?>" required>
            </label>

            <label>
                Fabricante *
                <input type="text" name="fabricante" value="<?= e($videoGame['fabricante'] ?? '') ?>" required>
            </label>

            <label>
                Geracao
                <input type="text" name="geracao" value="<?= e($videoGame['geracao'] ?? '') ?>" placeholder="Ex: 9a geracao">
            </label>

            <label>
                Ano de lancamento *
                <input type="number" name="ano_lancamento" min="1970" max="2100" value="<?= e((string)($videoGame['ano_lancamento'] ?? '')) ?>" required>
            </label>

            <label>
                Midia
                <input type="text" name="midia" value="<?= e($videoGame['midia'] ?? '') ?>" placeholder="Cartucho, DVD, Blu-ray, Digital">
            </label>

            <label>
                Imagem
                <input type="file" name="imagem" accept=".jpg,.jpeg,.png,.webp">
            </label>
        </div>

        <?php if (!empty($videoGame['imagem'])): ?>
            <div class="current-image">
                <span>Imagem atual</span>
                <img src="<?= asset($videoGame['imagem']) ?>" alt="<?= e($videoGame['nome']) ?>">
            </div>
        <?php endif; ?>

        <label>
            Descricao
            <textarea name="descricao" rows="5"><?= e($videoGame['descricao'] ?? '') ?></textarea>
        </label>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
            <a class="btn btn-secondary" href="<?= base_url('/admin/videogames') ?>">Cancelar</a>
        </div>
    </form>
</section>
