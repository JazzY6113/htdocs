<div class="admin-container">
    <h1 class="admin-header">Возврат книги</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group">
            <label>Выберите выдачу:
                <select name="loan_id" required>
                    <option value="">-- Выберите выдачу --</option>
                    <?php foreach ($activeLoans as $loan): ?>
                        <option value="<?= $loan->loan_id ?>">
                            <?= htmlspecialchars($loan->book->title) ?> →
                            <?= htmlspecialchars($loan->reader->getFullName()) ?>
                            (до <?= date('d.m.Y', strtotime($loan->due_date)) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <button type="submit" class="btn">Принять возврат</button>
    </form>
</div>