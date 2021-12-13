<?php require \Helpers\get_fragment_path('__header') ?>
    <?php
        $_GET['pricefrom'] = '';
    ?>
    <h2><?php echo \Settings\NO_DATA_FOUND_PHRASE ?><a href="/spending<?php echo \Helpers\get_GET_params(\Settings\GET_PARAMS) ?>">Изменить условия фильтрации</a></h2>

<?php require \Helpers\get_fragment_path('__footer') ?>