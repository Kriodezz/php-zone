<?php
include __DIR__ . '/../header.php'; ?>

<h1><?php echo $article->getName(); ?></h1>

<p><?php echo $article->getText(); ?></p>

<p><?php echo $article->getAuthor() ? $article->getAuthor()->getNickname() : 'ddd'; ?></p>

<?php
if (isset($user)) {
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
} ?>

<?php include __DIR__ . '/../footer.php';
