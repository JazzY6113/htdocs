<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Pop it MVC</title>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php else: ?>
            <?php if (app()->auth::user()->role === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/users') ?>">Управление пользователями</a>
            <?php elseif (app()->auth::user()->role === 'librarian'): ?>
                <a href="<?= app()->route->getUrl('/library') ?>">Библиотека</a>
                <a href="<?= app()->route->getUrl('/add-reader') ?>">Добавить читателя</a>
                <a href="<?= app()->route->getUrl('/add-book') ?>">Добавить книгу</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <div class="background-main">
        <img src="img/background.jpg" alt="background">
    </div>
    <?= $content ?? '' ?>
</main>
</body>
</html>