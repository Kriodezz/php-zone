<?php include __DIR__ . '/../header.php'; ?>

<h1>Редактирование статьи</h1>

<?php if(!empty($error)) { ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php } ?>

<form action="/admin/articles/<?php echo $article->getId(); ?>/edit" method="post">

    <label for="name">Название статьи</label><br>
    <input type="text"
           name="name" id="name"
           value="<?php echo $_POST['name'] ?? $article->getName(); ?>"
           size="50">
    <br>
    <br>

    <label for="text">Текст статьи</label><br>
    <textarea name="text"
              id="text"
              rows="10"
              cols="80"><?php echo $_POST['text'] ?? $article->getText(); ?></textarea>
    <br>
    <br>

    <input type="submit" value="Отредактировать">

</form>

<br>

<a href="/admin/articles">
    <button>Отмена</button>
</a>

<?php include __DIR__ . '/../footer.php'; ?>
