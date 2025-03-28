<div class="admin-container">
    <h1 class="admin-header">Добавление новой книги</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group">
            <label>Название:
                <input type="text" name="title" value="<?= htmlspecialchars($formData['title'] ?? '') ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Автор:
                <select name="author_id" required>
                    <option value="">Выберите автора</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->author_id ?>"
                            <?= ($formData['author_id'] ?? '') == $author->author_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($author->getFullName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Жанры:
                <select name="genres[]" multiple class="form-control">
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= $genre->genre_id ?>"
                            <?= isset($formData['genres']) && in_array($genre->genre_id, $formData['genres']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Издательство:
                <select name="publisher_id" required>
                    <option value="">Выберите издательство</option>
                    <?php foreach ($publishers as $publisher): ?>
                        <option value="<?= $publisher->publisher_id ?>"
                            <?= ($formData['publisher_id'] ?? '') == $publisher->publisher_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($publisher->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label>Год издания:
                <input type="number" name="publication_year"
                       value="<?= htmlspecialchars($formData['publication_year'] ?? '') ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Цена:
                <input type="number" step="0.01" name="price"
                       value="<?= htmlspecialchars($formData['price'] ?? '') ?>" required>
            </label>
        </div>

        <div class="form-group">
            <label>Количество экземпляров:
                <input type="number" name="total_copies"
                       value="<?= htmlspecialchars($formData['total_copies'] ?? 1) ?>" required min="1">
            </label>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_new_edition" value="1"
                    <?= isset($formData['is_new_edition']) && $formData['is_new_edition'] ? 'checked' : '' ?>>
                Новое издание
            </label>
        </div>

        <div class="form-group">
            <label>Аннотация:
                <textarea name="summary"><?= htmlspecialchars($formData['summary'] ?? '') ?></textarea>
            </label>
        </div>

        <button type="submit" class="btn">Добавить книгу</button>
    </form>
</div>