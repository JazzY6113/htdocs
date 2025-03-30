<div class="admin-container">
    <a href="/library" class="btn back-btn">← Назад в библиотеку</a><br>
    <h1 class="admin-header">Самые популярные книги</h1>

    <?php if ($books->count() > 0): ?>
        <table class="user-table">
            <thead>
            <tr>
                <th>Название книги</th>
                <th>Автор</th>
                <th>Год издания</th>
                <th>Количество выдач</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book->title) ?></td>
                    <td><?= htmlspecialchars($book->author->surname . ' ' . $book->author->name) ?></td>
                    <td><?= $book->publication_year ?></td>
                    <td><?= $book->loans_count ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет данных о популярных книгах</p>
    <?php endif; ?>
</div>