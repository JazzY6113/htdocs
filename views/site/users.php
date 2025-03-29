<div class="admin-container">
    <h1 class="admin-header">Управление пользователями</h1>

    <h2>Пользователи на подтверждение</h2>

    <?php foreach ($users as $user): ?>
        <div class="user-card">
            <div class="user-info">
                <strong><?= $user->getFullName() ?></strong> (Логин: <?= $user->login ?>)
            </div>
            <form method="post" action="/approve-user" class="user-actions">
                <input type="hidden" name="id" value="<?= $user->user_id ?>">
                <select name="role" class="form-select">
                    <option value="librarian">Библиотекарь</option>
                    <option value="user">Пользователь</option>
                </select>
                <button type="submit" class="btn">Подтвердить</button>
            </form>
        </div>
    <?php endforeach; ?>
    <div class="create-user">
        <a href="/create-user" class="btn" style="margin-top: 20px;">Создать нового пользователя</a>
    </div>
</div>