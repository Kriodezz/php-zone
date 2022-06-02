<?php include __DIR__ . '/adminHeader.php'; ?>

<a href="/admin/index">
    <button>Назад</button>
</a>

<table>

    <tr>
        <td>
            <b>Последние комментарии</b>
        </td>
    </tr>
    <tr>
        <td>
            <ul>
            <?php foreach ($comments as $comment) { ?>

                <li>
                    <a href="/articles/<?php echo $comment->getArticleId() .
                        '#comment' . $comment->getId(); ?>">
                        <?php echo $comment->getComment(); ?>
                    </a> || <a href="/admin/comments/<?php echo $comment->getId(); ?>/edit">
                        Редактировать
                    </a> || <a href="/admin/comments/<?php echo $comment->getId(); ?>/delete">
                        Удалить
                    </a>
                </li>
                <br>

            <?php } ?>
            </ul>
        </td>
    </tr>
</table>

<?php include __DIR__ . '/adminFooter.php'; ?>
