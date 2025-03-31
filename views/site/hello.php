<div class="avatar-container">
    <?php
    $user = app()->auth::user();
    $avatarPath = $user->getAvatarPath();
    ?>

    <img src="<?= htmlspecialchars($avatarPath, ENT_QUOTES, 'UTF-8') ?>"
         alt="Аватар" class="avatar" width="150" height="150">

    <form method="post" action="/upload-avatar" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
        <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif" required>
        <button type="submit" class="btn">Загрузить аватар</button>
    </form>
</div>