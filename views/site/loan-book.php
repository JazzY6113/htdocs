<div class="admin-container">
    <a href="/library" class="btn back-btn">← Назад в библиотеку</a><br>
    <h1 class="admin-header">Выдача книги читателю</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group">
            <label>Выберите книгу:
                <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
                <select name="book_id" required>
                    <option value="">-- Выберите книгу --</option>
                    <?php foreach ($books as $book): ?>
                        <option value="<?= $book->book_id ?>">
                            <?= htmlspecialchars($book->title) ?>
                            (Доступно: <?= $book->available_copies ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Выберите читателя:
                <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
                <select name="reader_id" required>
                    <option value="">-- Выберите читателя --</option>
                    <?php foreach ($readers as $reader): ?>
                        <option value="<?= $reader->reader_id ?>">
                            <?= htmlspecialchars($reader->getFullName()) ?>
                            (№<?= $reader->library_card_number ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <button type="submit" class="btn">Выдать книгу</button>
    </form>
</div>