
<form id="filter_form" >
    <input type="text" name="filter" placeholder="Фильтрация"
    value="<?php echo ($_GET['filter'] ?? '') ?>">
    <input type="number" placeholder="Минимальная стоимость" name="pricefrom" value="<?php echo ($_GET['pricefrom'] ?? '') ?>">
    <input type="number" placeholder="Максимальная стоимость" name="priceto" value="<?php echo ($_GET['priceto'] ?? '') ?>">
    <input type="datetime-local" name="from">
    <input type="submit" value="Вперед">
</form>
