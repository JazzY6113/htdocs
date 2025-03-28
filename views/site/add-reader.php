<div class="admin-container">
    <h1 class="admin-header">Добавление нового читателя</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
            <?php if (strpos($error, 'Duplicate entry') !== false): ?>
                <p>Попробуйте оставить поле "Номер читательского билета" пустым для автоматической генерации</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group">
            <label>Фамилия: <input type="text" name="surname" value="<?= htmlspecialchars($formData['surname'] ?? '') ?>" required></label>
        </div>
        <div class="form-group">
            <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>" required></label>
        </div>
        <div class="form-group">
            <label>Отчество: <input type="text" name="patronymic" value="<?= htmlspecialchars($formData['patronymic'] ?? '') ?>"></label>
        </div>
        <div class="form-group">
            <label>Номер читательского билета:
                <input type="text" name="library_card_number"
                       value="<?= htmlspecialchars($formData['library_card_number'] ?? '') ?>"
                       placeholder="Оставьте ПУСТЫМ для автоматической генерации">
                <small class="hint">Система автоматически сгенерирует уникальный номер</small>
            </label>
        </div>
        <div class="form-group">
            <label>Адрес: <textarea name="address" required><?= htmlspecialchars($formData['address'] ?? '') ?></textarea></label>
        </div>
        <div class="form-group">
            <label>Телефон: <input type="tel" name="phone" value="<?= htmlspecialchars($formData['phone'] ?? '') ?>" required></label>
        </div>
        <button type="submit" class="btn">Добавить читателя</button>
    </form>
</div>