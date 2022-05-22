<?php include __DIR__ . '/../header.php';


foreach ($articles as $article): ?>
    <h2>
        <a href="/articles/<?php echo $article->getId(); ?>">
            <?php echo $article->getName(); ?>
        </a>
    </h2>
    <p><?php echo $article->getText(); ?></p>
    <hr>
<?php endforeach;

include __DIR__ . '/../footer.php';
