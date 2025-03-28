<div class="admin-container">
    <h1 class="admin-header">Управление штрафами</h1>

    <table class="user-table">
        <thead>
        <tr>
            <th>Читатель</th>
            <th>Книга</th>
            <th>Дней просрочки</th>
            <th>Сумма штрафа</th>
            <th>Дата начисления</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($fines as $fine): ?>
            <tr>
                <td><?= htmlspecialchars($fine->reader->getFullName()) ?></td>
                <td><?= htmlspecialchars($fine->loan->book->title) ?></td>
                <td><?= $fine->loan->getOverdueDays() ?></td>
                <td><?= number_format($fine->amount, 2) ?> руб.</td>
                <td><?= $fine->issue_date ?></td>
                <td><?= $fine->status === 'paid' ? 'Оплачен' : 'Не оплачен' ?></td>
                <td>
                    <?php if ($fine->status === 'unpaid'): ?>
                        <form method="post" action="/pay-fine">
                            <input type="hidden" name="fine_id" value="<?= $fine->fine_id ?>">
                            <button type="submit" class="btn btn-sm">Отметить как оплаченный</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>