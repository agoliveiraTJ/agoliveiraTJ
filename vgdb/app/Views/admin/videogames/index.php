<?php
$currentSort = $currentSort ?? 'nome';
$currentDirection = $currentDirection ?? 'asc';

$sortUrl = function (string $column) use ($currentSort, $currentDirection): string {
    $nextDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
    return base_url('/admin/videogames?sort=' . $column . '&direction=' . $nextDirection);
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
            <h1>Video Games</h1>
        </div>
        <a class="btn btn-primary" href="<?= base_url('/admin/videogames/novo') ?>">Novo Video Game</a>
    </div>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>
                        <a class="sort-link<?= e($sortClass('id')) ?>" href="<?= e($sortUrl('id')) ?>">
                            ID <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('nome')) ?>" href="<?= e($sortUrl('nome')) ?>">
                            Nome <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('fabricante')) ?>" href="<?= e($sortUrl('fabricante')) ?>">
                            Fabricante <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('ano_lancamento')) ?>" href="<?= e($sortUrl('ano_lancamento')) ?>">
                            Ano <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>
                        <a class="sort-link<?= e($sortClass('midia')) ?>" href="<?= e($sortUrl('midia')) ?>">
                            Midia <span class="sort-icon" aria-hidden="true"></span>
                        </a>
                    </th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($videoGames as $videoGame): ?>
                    <tr>
                        <td><?= e((string)$videoGame['id']) ?></td>
                        <td><?= e($videoGame['nome']) ?></td>
                        <td><?= e($videoGame['fabricante']) ?></td>
                        <td><?= e((string)$videoGame['ano_lancamento']) ?></td>
                        <td><?= e($videoGame['midia']) ?></td>
                        <td class="table-actions">
                            <a href="<?= base_url('/admin/videogames/' . $videoGame['id'] . '/editar') ?>">Editar</a>
                            <form action="<?= base_url('/admin/videogames/' . $videoGame['id'] . '/excluir') ?>" method="post" onsubmit="return confirm('Excluir este Video Game?');">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$videoGames): ?>
                    <tr><td colspan="6">Nenhum Video Game cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
