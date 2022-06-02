<h3>Комментарии к статье</h3>

<?php if (!empty($error)) { ?>
    <div style="background-color: red; padding: 5px;margin: 15px">
        <?php echo $error; ?>
    </div>
<?php }

if ($user !== null) { ?>

    <form action="/articles/<?php echo $article->getId(); ?>/comments" method="post">

        <textarea
            name="comment"
            id="comment"
            cols="30"
            rows="5"
            placeholder="Оставьте комментарий"
                ></textarea>
    <br><br>

    <button type="submit">Отправить</button>

</form>

<?php } else { ?>

    <div>
        <a href="/users/register">Зарегистрируйтесь,</a> чтобы оставить комментарий. Или
        <a href="/users/login">войдите на сайт</a>
    </div>

<?php }

if (isset($comments)) {

    foreach ($comments as $comment) { ?>
        <p id="comment<?php echo $comment->getID(); ?>"><?php echo $comment->getComment(); ?></p>

        <?php if (isset($commentEdit) && $commentEdit === $comment->getID()) {
            include __DIR__ . '/formCommentEdit.php';
        }

        if ($user !== null) {
            if ( ('admin' === $user->getRole()) || ($comment->getUserId() === $user->getId()) ) { ?>
                <a href="/comments/<?php echo $comment->getID(); ?>/edit">Редактировать комментарий</a>
                <br>
                <a href="/comments/<?php echo $comment->getID(); ?>/delete">Удалить комментарий</a>
            <?php } ?>
        <?php } ?>

        <hr>
    <?php }

}
