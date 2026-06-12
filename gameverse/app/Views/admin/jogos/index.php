<?php
$currentSort = $currentSort ?? 'titulo';
$currentDirection = $currentDirection ?? 'asc';

$sortUrl = function (string $column) use ($currentSort, $currentDirection): string {
    $nextDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
    return base_url('/admin/jogos?sort=' . $column . '&direction=' . $nextDirection);
};

$sortClass = function (string $column) use ($currentSort, $currentDirection): string {
    if ($currentSort !== $column) {
        return '';
    }

    return ' is-active sort-' . $currentDirection;
};
?>

<section class="container section">
    <div class="admin-header">
        <div>
            <p class="eyebrow">Admin</p>
            <h1>Jogos</h1>
        </div>
        <a class="btn btn-primary" href="<?= base_url('/admin/jogos/novo') ?>">Novo Jogo</a>
    </div>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>
                        <a class="sort-link<?= e($sortClass('titulo')) ?>" href="<?= e($sortUrl('titulo')) ?>">
                            Titulo <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('genero')) ?>" href="<?= e($sortUrl('genero')) ?>">
                            Genero <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('ano_lancamento')) ?>" href="<?= e($sortUrl('ano_lancamento')) ?>">
                            Ano <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('plataformas')) ?>" href="<?= e($sortUrl('plataformas')) ?>">
                            Plataformas <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jogos as $jogo): ?>
                    <tr>
                        <td><?= e($jogo['titulo']) ?></td>
                        <td><?= e($jogo['genero']) ?></td>
                        <td><?= e((string)$jogo['ano_lancamento']) ?></td>
                        <td><?= e($jogo['plataformas'] ?? '-') ?></td>
                        <td class="table-actions">
                            <a href="<?= base_url('/admin/jogos/' . $jogo['id'] . '/editar') ?>">Editar</a>
                            <form action="<?= base_url('/admin/jogos/' . $jogo['id'] . '/excluir') ?>" method="post" onsubmit="return confirm('Excluir este jogo?');">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$jogos): ?>
                    <tr><td colspan="5">Nenhum jogo cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
