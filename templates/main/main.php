<?php include __DIR__ . '/../header.php';

foreach ($articles as $article): ?>
    <h2>
        <a href="/articles/<?php echo $article->getId(); ?>">
            <?php echo $article->getName(); ?>
        </a>
    </h2>
    <p><?php echo $article->getText(); ?></p>
    <hr>
<?php endforeach; ?>

    <div style="text-align: center">
        <?php for ($pageNum = 1; $pageNum <= $pagesCount; $pageNum++): ?>
            <?php if ($currentPageNum === $pageNum): ?>
                <b><?php echo $pageNum; ?></b>
            <?php else: ?>
                <a href="/<?php echo $pageNum == 1 ? '' : $pageNum; ?>">
                    <?php echo $pageNum; ?>
                </a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

<?php include __DIR__ . '/../footer.php';
