<?php require \Helpers\get_fragment_path('__header'); ?>
<?php
if (strlen(\Helpers\get_GET_params(\Settings\GET_PARAMS)) < 1)
    $mark = '?';
else
    $mark = '&'
?>
<div class="container">
    <div class="menu">
        <div id="add"><a href="/spending<?php echo \Helpers\get_GET_params(\Settings\GET_PARAMS) . $mark . 'action=add'?>">кнопка 1</a></div>
        <div id="edit"><a> кнопка 2</a></div>
        <div id="filter"><a> кнопка 3</a></div>
        <div id="help"><a> кнопка 4</a></div>
    </div>
    <div class="display-and-control">
        <div class="display" id="main-window">
            <?php if (isset($paginator))
                require \Helpers\get_fragment_path('__paginator') ?>
        </div>
        <div class="control">
            <?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) require \Helpers\get_fragment_path('__add_item_form'); ?>
            <?php if (isset($_GET['action']) && $_GET['action'] == 'filter' ) require \Helpers\get_fragment_path('__filter_form'); ?>
        </div>
    </div>
</div>

<?php require \Helpers\get_fragment_path('__footer') ?>

<script type="text/javascript">

    const main_window = document.getElementById('main-window');

    class mainDisplay {
        constructor() {
            this.obj = main_window;
            this.lastDay = null;
            this.message = 'Кажется, трат у Вас нет. Экономите? Так держать!';

            let div, h2;
            div = document.createElement('div');
            h2 = document.createElement('h2');
            h2.textContent = 'Мои расходы';
            div.appendChild(h2);
            this.obj.appendChild(div);
        }
        createNewDay(day, month, year) {
            let new_day = new oneDay(day, month, year, this);
            this.obj.appendChild(new_day.obj);
            this.lastDay = new_day;
        }
    }
    class Item {
        categories = ['Разное', 'Еда', 'Развлечения', 'Здоровье'];

        constructor(id, price, title, description, amount, price_per_one, measure, category, user, uploaded, display) {
            this.price = price;
            this.title = title;
            this.description = description;
            this.amount = amount;
            this.price_per_one = price_per_one;
            this.measure = measure;
            this.category = category;
            this.user = user;
            this.uploaded = uploaded;
            this.obj = null;
            this.display = display;
            this.day = this.uploaded[8] + this.uploaded[9];
            this.year = this.uploaded[0] + this.uploaded[1] + this.uploaded[2] +this.uploaded[3];
            this.month = this.uploaded[5] + this.uploaded[6];
            this.id = id;

        }

        createItem() {
            if (this.display.lastDay == null || this.display.lastDay.day != this.day) {
                this.display.createNewDay(this.day, this.month, this.year);
            }
            // теперь объект нужного дня существует
            let img, div, h3, a;
            let first_block = document.createElement('div');
            let second_block = document.createElement('div');
            let new_obj = document.createElement('div');
            new_obj.classList.add('item');
            first_block.classList.add('price-and-pic');
            second_block.classList.add('other');

            div = document.createElement('div');
            div.classList.add('category');
            div.textContent = this.categories[this.category - 1];
            new_obj.appendChild(div);

            div = document.createElement('div');
            div.classList.add('delete-and-change');
            a = document.createElement('a');
            a.href = '/spending/<?php echo \Helpers\get_GET_params(\Settings\GET_PARAMS, ['action' => 'edit'])?>' + '&id=' + this.id;
            a.textContent = 'Редактировать';
            div.appendChild(a);
            a = document.createElement('a');
            a.href = '/spending/<?php echo \Helpers\get_GET_params(\Settings\GET_PARAMS, ['action' => 'delete'])?>' + '&id=' + this.id;
            a.textContent = 'Удалить';
            div.appendChild(a);
            new_obj.appendChild(div);


            div = document.createElement('div');
            div.classList.add('item-picture');
            img = document.createElement('img');
            img.src = '../images/' + this.category + '.jpg';
            div.appendChild(img);
            first_block.appendChild(div);

            div = document.createElement('div');
            div.classList.add('item-price');
            div.textContent = this.price;
            first_block.appendChild(div);

            div = document.createElement('div');
            div.classList.add('item-title');
            div.textContent = this.title;
            second_block.appendChild(div);

            if (this.description != null && this.description != 0 && this.description != '') {
                div = document.createElement('div');
                div.classList.add('item-description');
                div.textContent = this.description;
                second_block.appendChild(div);
            }
            if (this.amount != null && this.amount != 0 && this.amount != '' && this.price_per_one != null && this.price_per_one != 0 && this.price_per_one != '') {
                div = document.createElement('div');
                div.classList.add('item-amount');
                div.innerHTML = this.amount + ' ' + this.measure + '. &mdash; ' + this.price_per_one + 'руб/' + this.measure;
                second_block.appendChild(div);
            }

            div = document.createElement('div');
            div.classList.add('item-uploaded');
            div.textContent = this.uploaded;
            second_block.appendChild(div);



            let blocks = document.createElement('div');
            blocks.classList.add('item-info')
            blocks.appendChild(first_block);
            blocks.appendChild(second_block);
            new_obj.appendChild(blocks);

            new_obj.appendChild(document.createElement('hr'));


            // осталось лишь добваить new_obj
                this.obj = new_obj;
            this.display.lastDay.obj.appendChild(new_obj);



        }


    }
    class oneDay {
        constructor(day,month, year, display) {
            this.day = day;
            this.year = year;
            this.month = parseInt(month);
            this.months = ['123','января', 'февраля', 'марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];


            this.obj = document.createElement('div');
            let str_made = this.day + ' ' + this.months[this.month];
            if (this.year != SETTINGS_YEAR)
                str_made += ' ' + this.year + ' г.'
            this.obj.textContent = str_made;

            this.display = display;
        }


    }




    let main_display = new mainDisplay();

    <?php
    foreach ($items as $item) { ?>
    //(price, title, description, amount, price_per_one, measure, category, user, uploaded, display)
    new_el = new Item(<?php echo $item['id'] ?>, <?php echo $item['price'] ?>, <?php echo "'" . $item['title'] . "'" ?>, <?php echo (($item['description'] == '') ? 'null' : "'" . $item['description'] . "'") ?>, <?php echo (($item['amount'] == '') ? 'null' : $item['amount']) ?>,<?php echo (($item['price_per_one'] == '') ? 'null' : $item['price_per_one']) ?>, <?php echo (($item['measure'] == '') ? 'null' : "'" . $item['measure'] . "'") ?>, <?php echo "'" . $item['category'] . "'" ?>, <?php echo "'" . $item['user'] . "'" ?>,<?php echo "'" . $item['uploaded'] . "'" ?>, main_display);

    new_el.createItem();

        <?php

    echo '123';} ?>


    <?php if (isset($_GET['action']) && $_GET['action'] == 'add' ) { ?>
    let price_field = document.getElementById('new-item-price');
    let price_per_one_field = document.getElementById('new-item-price_per_one');
    let amount_field = document.getElementById('new-item-amount');

    function price_auto_fill() {
        let changed;
        if (this.id === 'new-item-price') {
            if (amount_field.value != '' && amount_field.value != '0' && price_field.value != '') {
                price_per_one_field.value = price_field.value / amount_field.value;
                changed = price_per_one_field;
            }
            else if (price_per_one_field.value != '' && price_per_one_field.value != '0' && price_field.value != '') {
                amount_field.value = price_field.value / price_per_one_field.value;
                changed = amount_field;
            }
        }
        else if (this.id === 'new-item-price_per_one') {
            if (price_per_one_field.value != '0' && price_per_one_field.value != '' && price_field.value != '') {
                amount_field.value = price_field.value / price_per_one_field.value;
                changed = amount_field;
            }
        }
        else if (this.id === 'new-item-amount') {
            if (amount_field.value != '0' && amount_field.value != '' && price_field.value != '') {
                price_per_one_field.value = price_field.value / amount_field.value;
                changed = price_per_one_field;
            }
        }
        if (changed.value == 'NaN')
            changed.value = '';
    }

    price_field.addEventListener('change', price_auto_fill);
    price_per_one_field.addEventListener('change', price_auto_fill);
    amount_field.addEventListener('change', price_auto_fill);
    <?php } ?>

    if (main_display.obj.children.length <= 1)
        main_display.obj.textContent = "<?php echo \Settings\NO_DATA_FOUND_PHRASE ?>"

</script>