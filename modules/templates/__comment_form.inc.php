<form class="bigform" method="post">
    <label for="comment_user">Пользователь</label>
    <select id="comment_user" name="user">
        <?php foreach ($users as $user) { ?>
            <option value="<?php echo $user['id'] ?>"
                    <?php if ($form['user'] == $user['id']) { ?>selected<?php } ?>>
                <?php echo $user['name'] ?>
            </option>
        <?php } ?>
    </select>
    <label for="comment_contents">Содержание</label>
    <textarea id="comment_contents" name="contents"><?php echo $form['contents'] ?></textarea>
    <?php \Helpers\show_errors('contents', $form) ?>
    <input type="submit" value="Отправить">
</form>

