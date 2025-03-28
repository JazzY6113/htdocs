<div class="admin-container">
    <h1 class="admin-header">Прием возвращенных книг</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <table class="user-table">
        <thead>
        <tr>
            <th>Книга</th>
            <th>Читатель</th>
            <th>Дата выдачи</th>
            <th>Срок возврата</th>
            <th>Статус</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($activeLoans as $loan): ?>
            <tr>
                <td><?= htmlspecialchars($loan->book->title) ?></td>
                <td><?= htmlspecialchars($loan->reader->getFullName()) ?></td>
                <td><?= date('d.m.Y', strtotime($loan->loan_date)) ?></td>
                <td><?= date('d.m.Y', strtotime($loan->due_date)) ?></td>
                <td>
                    <?php if ($loan->isOverdue()): ?>
                        <span class="badge bg-danger">
                            Просрочено (<?= number_format($loan->calculateFine(), 2) ?> руб.)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success">На руках</span>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="post" action="/return-book">
                        <input type="hidden" name="loan_id" value="<?= $loan->loan_id ?>">
                        <button type="submit" class="btn btn-sm">Принять возврат</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>