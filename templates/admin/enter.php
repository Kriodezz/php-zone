<?php include __DIR__ . '/adminHeader.php'; ?>


<div style="text-align: center;">
    <h1>Вход</h1>
    <?php if (!empty($error)) { ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?php echo $error; ?></div>
    <?php } ?>
    <form action="/admin/482" method="post">

        <label>Email
            <input type="text" name="email" value="<?php echo $_POST['email'] ?? ''; ?>">
        </label>
        <br><br>

        <label>Пароль
            <input type="password" name="password" value="<?php echo $_POST['password'] ?? ''; ?>">
        </label>
        <br><br>

        <input type="submit" value="Войти">
    </form>
</div>

<?php include __DIR__ . '/adminFooter.php'; ?>
