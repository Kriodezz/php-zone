<?php include __DIR__ . '/../header.php'; ?>

<h1><?php echo $article->getName(); ?></h1>

<p><?php echo $article->getText(); ?></p>

<p>
    <?php echo $article->getAuthor() ? $article->getAuthor()->getNickname() : 'Автор неизвестен'; ?>
</p>

<?php if ($user !== null) {

    if ('admin' === $user->getRole()) { ?>
        <ul>
            <li>
                <a href="/articles/<?php echo $article->getId(); ?>/edit">
                    Редактировать статью
                </a>
            </li>

            <li>
                <a href="/articles/<?php echo $article->getId(); ?>/delete">
                    Удалить статью
                </a>
            </li>
        </ul>
    <?php }

} ?>

<hr color="green">

<?php include __DIR__ . '/comments.php';

include __DIR__ . '/../footer.php';
