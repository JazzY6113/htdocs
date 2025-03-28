<div class="admin-container">
    <h1 class="admin-header">Книги у читателей</h1>

    <form method="get" class="filter-form">
        <div class="form-group">
            <label>Выберите читателя:
                <select name="reader_id" class="form-control">
                    <option value="">Все читатели</option>
                    <?php foreach ($readers as $reader): ?>
                        <option value="<?= $reader->reader_id ?>"
                            <?= $selectedReader && $selectedReader->reader_id == $reader->reader_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($reader->surname . ' ' . $reader->name) ?>
                            (№<?= $reader->library_card_number ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit" class="btn">Показать</button>
        </div>
    </form>

    <?php if ($loans->count() > 0): ?>
        <table class="user-table">
            <thead>
            <tr>
                <th>Название книги</th>
                <th>Читатель</th>
                <th>Дата выдачи</th>
                <th>Срок возврата</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?= htmlspecialchars($loan->book->title) ?></td>
                    <td>
                        <?= htmlspecialchars($loan->reader->surname . ' ' . $loan->reader->name) ?><br>
                        <small>№<?= $loan->reader->library_card_number ?></small>
                    </td>
                    <td><?= date('d.m.Y', strtotime($loan->loan_date)) ?></td>
                    <td><?= date('d.m.Y', strtotime($loan->due_date)) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет активных выдач</p>
    <?php endif; ?>
</div>