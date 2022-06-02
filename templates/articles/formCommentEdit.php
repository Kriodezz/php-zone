<form
    action="/comments/<?php echo $comment->getId(); ?>/edit"
    method="post"
>

    <textarea
            name="edit-comment"
            cols="30"
            rows="5"
    ><?php echo $comment->getComment(); ?></textarea>
    <br><br>

    <button type="submit">Изменить</button>

</form>
