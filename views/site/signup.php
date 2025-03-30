<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<div class="signup">
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Имя <input type="text" name="name"></label>
        <label>Логин <input type="text" name="login"></label>
        <label>Пароль <input type="password" name="password"></label>
        <button type="submit" class="btn">Регистрация</button>
    </form>
</div>