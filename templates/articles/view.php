<?php
include __DIR__ . '/../header.php'; ?>
    <h1><?php echo $article->getName(); ?></h1>
    <p><?php echo $article->getText(); ?></p>
<p><?php echo $article->getAuthor() ? $article->getAuthor()->getNickname() : 'ddd'; ?></p>
<?php include __DIR__ . '/../footer.php';
