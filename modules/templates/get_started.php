<!doctype html>
<html>
<head>
    <script type="text/javascript" src="../../scripts/settings.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ((isset($site_title)) ?
            $site_title . ' :: ' : '') ?>
        <?php echo \Settings\SITE_NAME ?></title>
    <style type="text/css">

        * {
            overflow-x: hidden;
            margin: 0px;
            padding: 0px;
            max-width: 100vw;
        }
        header {
            height: 10vh;
            width: 100vw;
            background-color: bisque;
        }
        .container {
            width: 100vw;
            height: 90vh;
            display: grid;
            grid-template-columns: 1fr 5fr;
        }
        .menu {
            background-color: aquamarine;
        }
        .pag {
            width: 100%;
        }

        .display-and-control {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-around;
            align-content: space-around;
            align-items: center;
        }
        .display-and-control div {
        }
        .display {
            height: 70vh;
            width: 35vw;
        }
        .control {
            height: 70vh;
            width: 35vw;
        }
        .category {
            text-align: center;
        }
        .display {
            background-color: darkorange;
        }
        .item {
            display: flex;
            flex-direction: column;
        }
        .item-info {
            display: flex;
        }
        .price-and-pic {
            display: flex;
        }
        .other {
            display: flex;
            flex-direction: column;
        }

        .control {
            background-color: cornflowerblue;
        }

        @media screen and (max-width: 767px) {
            .container {
                grid-template-columns: 1fr;
            }
            .display-and-control div {
                height: 60vh;
                width: 90vw;
                margin-bottom: 5vh;
            }
            .display-and-control {
                flex-direction: column;
            }
            .menu {
                width: 100vw;
                height: 20vh;
                margin-bottom: 5vh;
            }
        }
    </style>
</head>


<body>
<header>
    <a href="/"><?php echo \Settings\SITE_NAME ?></a>

    <section id="logged">
        <?php if (isset($__current_user)) {?>
            <a href="/users/<?php echo $__current_user['name'] ?>">
                <?php echo $__current_user['name'] ?></a>
            <a href="/users/<?php echo $__current_user['name'] ?>/account/edit">Изменить данные</a>
            <a href="/users/<?php echo $__current_user['name'] ?>/account/editpassword">Сменить пароль</a>
            <a href="/logout">Выйти</a>
            <a href="/users/<?php echo $__current_user['name'] ?>/account/delete">Удалить пользователя</a>
        <?php } else { ?>
            <a href="/register">Зарегистрироваться</a>
            <a href="/login">Войти</a>
        <?php } ?>
    </section>
</header>
    <div class="starting-instructions">
        Добро пожаловать! Тут будет инструкция
    </div>

<?php require \Helpers\get_fragment_path('__footer') ?>