<!--<div class="admin-container">-->
<!--    <h1 class="admin-header">Панель библиотекаря</h1>-->
<!---->
<!--    <div class="quick-actions">-->
<!--        <a href="/add-book" class="btn">Добавить книгу</a>-->
<!--        <a href="/add-reader" class="btn">Добавить читателя</a>-->
<!--        <a href="/loan-book" class="btn">Выдать книгу</a>-->
<!--        <a href="/return-book" class="btn">Принять книгу</a>-->
<!--        <a href="/reader-books" class="btn">Книги у читателей</a>-->
<!--        <a href="/book-readers" class="btn">История книги</a>-->
<!--        <a href="/popular-books" class="btn">Популярные книги</a>-->
<!--    </div>-->
<!---->
<!--    <h2>Текущие выдачи</h2>-->
<!--    --><?php //if ($activeLoans->count() > 0): ?>
<!--        <table class="user-table">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Книга</th>-->
<!--                <th>Читатель</th>-->
<!--                <th>Дата выдачи</th>-->
<!--                <th>Срок возврата</th>-->
<!--                <th>Статус</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            --><?php //foreach ($activeLoans as $loan): ?>
<!--                <tr>-->
<!--                    <td>--><?php //= htmlspecialchars($loan->book->title) ?><!--</td>-->
<!--                    <td>--><?php //= htmlspecialchars($loan->reader->surname . ' ' . $loan->reader->name) ?><!--</td>-->
<!--                    <td>--><?php //= date('d.m.Y', strtotime($loan->loan_date)) ?><!--</td>-->
<!--                    <td>--><?php //= date('d.m.Y', strtotime($loan->due_date)) ?><!--</td>-->
<!--                    <td>--><?php //= $loan->status === 'overdue' ? 'Просрочено' : 'На руках' ?><!--</td>-->
<!--                </tr>-->
<!--            --><?php //endforeach; ?>
<!--            </tbody>-->
<!--        </table>-->
<!--    --><?php //else: ?>
<!--        <p>Нет активных выдач</p>-->
<!--    --><?php //endif; ?>
<!--</div>-->