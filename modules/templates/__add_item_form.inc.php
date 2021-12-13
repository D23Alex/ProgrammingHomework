<form class="bigform" method="post">
    <label for="item_cat">Категория</label>
    <select id="item_cat" name="category">
        <?php foreach ($categories as $category) { ?>
            <option <?php if ($category['id'] ==  $form['category'])
                echo "selected"; ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
        <?php } ?>
    </select>
    <label for="new-item-title">Название</label>
    <input id="new-item-title" name="title" value="<?php echo $form['title'] ?>">
    <label for="new-item-description" >Описание</label>
    <input id="new-item-description" name="description" value="<?php echo $form['description'] ?>">

    <label for="new-item-price">Цена</label>
    <input id="new-item-price" name="price" value="<?php echo $form['price'] ?>">
    <?php \Helpers\show_errors('price', $form); ?>

    <label for="new-item-amount">Количество</label>
    <input id="new-item-amount" name="amount" value="<?php echo $form['amount'] ?>">
    <?php \Helpers\show_errors('amount', $form); ?>

    <select id="item-measure" name="measure" value="<?php echo $form['measure'] ?>">
        <option value="ед." selected>ед.</option>
        <option value="шт.">шт.</option>
        <option value="кг">кг</option>
        <option value="г">г</option>
        <option value="л">л</option>
        <option value="мл">мл</option>
        <option value="lbs">lbs</option>
    </select>

    <label for="new-item-price_per_one">цена за</label>
    <input id="new-item-price_per_one" name="price_per_one" value="<?php echo $form['price_per_one'] ?>">
    <?php \Helpers\show_errors('price_per_one', $form); ?>

    <label for="new-item-uploaded">Дата и время</label>
    <input type="date" id="new-item-date-uploaded" name="uploaded[]" value="<?php echo $form['uploaded'][0] ?>">
    <input type="time" id="new-item-time-uploaded" name="uploaded[]" value="<?php echo $form['uploaded'][1] ?>">
    <?php \Helpers\show_errors('uploaded', $form); ?>

    <input type="submit" value="Go">


</form>
