<?php
// этот контроллер - как и все - подкласс BaseController.
namespace Controllers;
use function Sodium\add;

class Spending extends BaseController {

    function get_started() {
        $this->render('get_started', []);
    }

    function items_main() {
        //TODO: исправить удаление и редактирование чужих записей
        if (!(isset($_GET['action'])) || (($_GET['action'] == 'edit' || $_GET['action'] == 'delete') && !(isset($_GET['id']))))
            $_GET['action'] = 'add';

        if ($_GET['action'] == 'add') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $add_form =
                    \Forms\Item::get_normalized_data($_POST);
                if (!isset($add_form['__errors'])) {
                    $add_form = \Forms\Item::get_prepared_data($add_form);
                    $add_form['user'] = $this->current_user['id'];
                    $items = new \Models\Item();
                    $items->insert($add_form);
                    \Helpers\redirect('/' . 'spending' .
                        \Helpers\get_GET_params(['page', 'filter',
                            'ref', 'from', 'to', 'pricefrom', 'priceto', 'category', 'action', 'id']));
                }
            } else
                $add_form = \Forms\Item::get_initial_data(['uploaded' => time()]);
        }
        else if ($_GET['action'] == 'delete') {
            $add_form = \Forms\Item::get_initial_data(['uploaded' => time()]);
            $items = new \Models\Item();
            $a = $items->get_or_404($_GET['id']);
            // эта защита от хитрого пользователя, который с помощью гет параметров попытается удалить чужую запись
            if ($a['user'] == $this->current_user['id'])
                $items->delete($_GET['id']);
            \Helpers\redirect('/' . 'spending' .
                \Helpers\get_GET_params(['page', 'filter',
                    'ref', 'from', 'to', 'pricefrom', 'priceto', 'category']) . '&action=add');

        }
        else if ($_GET['action'] == 'edit') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $add_form =
                    \Forms\Item::get_normalized_data($_POST);
                if (!isset($add_form['__errors'])) {
                    $add_form = \Forms\Item::get_prepared_data($add_form);
                    $add_form['user'] = $this->current_user['id'];
                    $items = new \Models\Item();
                    $items->update($add_form, $_GET['id']);
                    \Helpers\redirect('/' . 'spending' .
                        \Helpers\get_GET_params(['page', 'filter',
                            'ref', 'from', 'to', 'pricefrom', 'priceto', 'category', 'action', 'id']));
                }
            } else {
                $items = new \Models\Item();
                $item = $items->get_or_404($_GET['id']);
                // эта защита от хитрого пользователя, который с помощью гет параметров попытается изменить чужую запись
                if ($item['user'] != $this->current_user['id'])
                    \Helpers\redirect('/spending?action=add' );
                else
                    $add_form = \Forms\Item::get_initial_data($item);
            }
        }

        //TODO: реализовать фильтр. Реализвовать сортировку.
        $users = new \Models\User();
        $items = new \Models\Item();

        $cat = new \Models\Category();
        $cat->select();


        $criteria = 'user = ?';
        $params = [$this->current_user['id']];

        if (isset($_GET['pricefrom']) && !empty($_GET['pricefrom'])) {
            $criteria .= ' AND price >= ?';
            $params[] = $_GET['pricefrom'];
        }
        if (isset($_GET['priceto']) && !empty($_GET['priceto'])) {
            $criteria .= ' AND price <= ?';
            $params[] = $_GET['priceto'];
        }
        if (isset($_GET['from']) && !empty($_GET['from'])) {
            $criteria .= ' AND uploaded >= ?';
            $params[] = $_GET['from'];
        }
        if (isset($_GET['to']) && !empty($_GET['to'])) {
            $criteria .= ' AND uploaded <= ?';
            $params[] = $_GET['to'];
        }
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $criteria .= ' AND category = ?';
            $params[] = $_GET['category'];
        }
        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $filter = '%' . $_GET['filter'] . '%';
            $criteria .= ' AND (title LIKE ? OR description LIKE ?)';
            $params[] = $filter;
            $params[] = $filter;
        }

        $item_count_rec = $items->get_record('COUNT(*) AS cnt', NULL, $criteria, $params);
        $item_count = $item_count_rec['cnt'];

        if ($item_count == 0)
        {
            $items->select('items.id,items.title , items.category, items.description, items.uploaded, items.measure, items.price, items.price_per_one, items.amount, items.user', ['users', 'categories'],
                $criteria, $params, '');
            $ctx = ['items' => $items, 'site_title' => ' :: ' . 'Придумать название', 'categories' => $cat];
            if (isset($add_form))
                $ctx['form'] = $add_form;
            $this->render('spending', $ctx);
        }
        else {
            $paginator = new \Paginator($item_count, ['action', 'id']);

            $items->select('items.id,items.title , items.category, items.description, items.uploaded, items.measure, items.price, items.price_per_one, items.amount, items.user', ['users', 'categories'],
                $criteria, $params, '', $paginator->first_record_num, \Settings\RECORDS_ON_PAGE);
            $ctx = ['items' => $items, 'paginator' => $paginator, 'site_title' => ' :: ' . 'Придумать название', 'categories' => $cat];
            if (isset($add_form))
                $ctx['form'] = $add_form;
            $this->render('spending', $ctx);
        }
    }

    function by_user(string $user_name) {
        $users = new \Models\User();
        $user = $users->get_or_404($user_name, 'name', 'id, name, name1, name2');


        $ctx = ['user' => $user, 'site_title' => $user['name'] . ' :: ' . 'Пользователи'];
        $this->render('by_user', $ctx);
    }

}