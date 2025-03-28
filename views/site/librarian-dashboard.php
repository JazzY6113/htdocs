<div class="admin-container">
    <h1 class="admin-header">Панель библиотекаря</h1>

    <div class="quick-actions">
        <a href="/add-book" class="btn">Добавить книгу</a>
        <a href="/add-reader" class="btn">Добавить читателя</a>
        <a href="/loan-book" class="btn">Выдать книгу</a>
        <a href="/return-book" class="btn">Принять книгу</a>
        <a href="/popular-books" class="btn">Популярные книги</a>
    </div>

    <h2>Текущие выдачи</h2>
    <?php if ($activeLoans->count() > 0): ?>
        <table class="user-table">
            <thead>
            <tr>
                <th>Книга</th>
                <th>Читатель</th>
                <th>Дата выдачи</th>
                <th>Срок возврата</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($activeLoans as $loan): ?>
                <tr>
                    <td><?= htmlspecialchars($loan->book->title) ?></td>
                    <td><?= htmlspecialchars($loan->reader->getFullName()) ?></td>
                    <td><?= $loan->loan_date ?></td>
                    <td><?= $loan->due_date ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет активных выдач</p>
    <?php endif; ?>
</div>