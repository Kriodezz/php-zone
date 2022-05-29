<?php
include __DIR__ . '/../header.php'; ?>

    <h1><?php echo $article->getName(); ?></h1>

    <p><?php echo $article->getText(); ?></p>

    <p>
        <?php echo $article->getAuthor() ? $article->getAuthor()->getNickname() : 'Автор неизвестен'; ?>
    </p>
    <hr color="green">

<?php
if ($user !== null) {

    if (!empty($error)) { ?>
        <div style="background-color: red; padding: 5px;margin: 15px">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form action="/articles/<?php echo $article->getId(); ?>/comments" method="post">

        <label for="comment">Комментарии к статье</label>
        <br><br>
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


    <?php
    if ('admin' === $user->getRole()) { ?>
        <ul>
            <li>
                <a href="/articles/<?php echo $article->getId(); ?>/edit">
                    Редактировать статью
                </a>
            </li>

            <li>
                <a href="/articles/<?php echo $article->getId(); ?>/remove">
                    Удалить статью
                </a>
            </li>
        </ul>
        <?php
    }
} else { ?>
    <div>
        <a href="/users/register">Зарегистрируйтесь,</a> чтобы оставить комментарий. Или
        <a href="/users/login">войдите на сайт</a>
    </div>
<?php } ?>


<?php if (isset($comments)) {
    foreach ($comments as $comment) { ?>
        <p><?php echo $comment; ?></p>
        <hr>
    <?php }
} ?>

<?php include __DIR__ . '/../footer.php';
