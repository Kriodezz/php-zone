<?php include __DIR__ . '/../header.php'; ?>

<div style="text-align: center;">

    <h2>Будьте индивидуальны - загрузите аватарку</h2>

    <?php if (!empty($error)) { ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?php echo $error; ?></div>
    <?php } ?>

    <form action="/users/<?php echo $user->getId(); ?>/load-avatar" method="post" enctype="multipart/form-data">

        <p><input type="file" name="user-avatar"></p>
        <p><input type="submit"></p>

    </form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
