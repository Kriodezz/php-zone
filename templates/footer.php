</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/">Главная страница</a></li>

        <?php
        if (isset($user)) {
            if ('admin' === $user->getRole()) { ?>
                    <li><a href="articles/create">Добавить новую статью</a></li>
        <?php
            }
        } ?>

    </ul>
</td>
</tr>
<tr>
    <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>

</body>
</html>
