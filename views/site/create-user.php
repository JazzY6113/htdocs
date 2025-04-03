<div class="admin-container">
    <h1 class="admin-header">Создание нового пользователя</h1>

    <form method="post" action="/create-user" class="admin-form">
        <div class="form-group">
            <label for="surname">Фамилия:</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <input type="text" id="surname" name="surname" required>
        </div><br>

        <div class="form-group">
            <label for="name">Имя:</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <input type="text" id="name" name="name" required>
        </div><br>

        <div class="form-group">
            <label for="patronymic">Отчество (необязательно):</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <input type="text" id="patronymic" name="patronymic">
        </div><br>

        <div class="form-group">
            <label for="login">Логин:</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <input type="text" id="login" name="login" required>
        </div><br>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <input type="password" id="password" name="password" required>
        </div><br>

        <div class="form-group">
            <label for="role">Роль:</label>
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <select id="role" name="role" required>
                <option value="librarian">Библиотекарь</option>
                <option value="user">Пользователь</option>
            </select>
        </div>
        <div class="create-user">
            <button type="submit" class="btn">Создать пользователя</button>
        </div>
    </form>
</div>