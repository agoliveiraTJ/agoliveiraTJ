<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'GameVerse') ?></title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="<?= base_url('/') ?>" aria-label="GameVerse home">
                <span class="brand-mark">GV</span>
                <span>GameVerse</span>
            </a>

            <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" data-menu-toggle>
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav" aria-label="Menu principal" data-main-nav>
                <a href="<?= base_url('/') ?>">Home</a>
                <a href="<?= base_url('/videogames') ?>">Video Games</a>
                <a href="<?= base_url('/jogos') ?>">Jogos</a>
                <a class="nav-admin" href="<?= base_url('/admin') ?>">Admin</a>
            </nav>
        </div>
    </header>

    <main>
        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <div class="container">
                <div class="alert alert-<?= e($flash['type']) ?>">
                    <?= e($flash['message']) ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-content">
            <p>&copy; <?= date('Y') ?> GameVerse - Cadastro MVC de Video Games e Jogos.</p>
            <a href="<?= base_url('/admin') ?>">Painel admin</a>
        </div>
    </footer>

    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
