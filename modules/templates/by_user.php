<?php require \Helpers\get_fragment_path('__header') ?>
<h2>Добро пожаловать, <?php if (isset($user['name1'])) {
    echo $user['name1'];
    if (isset($user['name2']))
        echo ' ' . $user['name2'];
} else echo $user['name'];
    ?>!</h2>
<h3>Узнайте свои расходы <a href="/spending?&action=add">здесь</a>!</h3>

<?php require \Helpers\get_fragment_path('__footer') ?>
