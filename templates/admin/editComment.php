<?php include __DIR__ . '/../header.php'; ?>

<h1>Редактирование статьи</h1>

<?php if(!empty($error)) { ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php } ?>

<form action="/admin/comments/<?php echo $comment->getId(); ?>/edit" method="post">

    <textarea name="edit-comment"
              id="text"
              rows="10"
              cols="80"><?php echo $_POST['text'] ?? $comment->getComment(); ?></textarea>

    <input type="submit" value="Отредактировать">

</form>

<?php include __DIR__ . '/../footer.php'; ?>
