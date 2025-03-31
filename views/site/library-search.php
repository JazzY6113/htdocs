<div class="admin-container">
    <h1 class="admin-header">Поиск книг</h1>

    <a href="/library" class="btn back-btn">← Назад в библиотеку</a><br><br>

    <form method="get" action="/library-search" class="search-form">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="search"
               value="<?= htmlspecialchars($searchTerm) ?>"
               placeholder="Название или автор"><br><br>
        <button type="submit" class="btn">Искать</button>
    </form><br>

    <?php if ($books->count() > 0): ?>
        <table class="book-table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Автор</th>
                <th>Год</th>
                <th>Доступно</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book->title) ?></td>
                    <td><?= htmlspecialchars($book->author->getFullName()) ?></td>
                    <td><?= $book->publication_year ?></td>
                    <td><?= $book->available_copies ?> из <?= $book->total_copies ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-results">По вашему запросу ничего не найдено</p>
    <?php endif; ?>
</div>