<?php include __DIR__ . '/adminHeader.php'; ?>

<a href="/admin/index">
    <button>Назад</button>
</a>

<table>

    <tr>
        <td>
        <b>Последние статьи</b>
        </td>
    </tr>
    <tr>
        <td>
            <ul>
            <?php foreach ($articles as $article) { ?>

                <li>
                    <a href="/articles/<?php echo $article->getId(); ?>">
                        <?php echo $article->getName(); ?>
                    </a> || <a href="/admin/articles/<?php echo $article->getId(); ?>/edit">
                        Редактировать
                    </a> || <a href="/admin/articles/<?php echo $article->getId(); ?>/delete">
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
