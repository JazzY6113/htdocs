<h2>Авторизация</h2>
<h3><?= $message ?? ''; ?></h3>

<h3><?= app()->auth->user()->name ?? ''; ?></h3>
<?php
if (!app()->auth::check()):
    ?>
    <div class="login">
        <form method="post">
            <input name="csrf_token" type="hidden" value="<?= \SimpleCSRF\CSRF::generateToken() ?>"/>
            <label>Логин <input type="text" name="login"></label>
            <label>Пароль <input type="password" name="password"></label>
            <button type="submit" class="btn">Авторизация</button>
        </form>
    </div>
<?php endif;