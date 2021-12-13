<?php
require_once $base_path . 'modules\helpers.php';
class Paginator implements \Iterator {
    public $current_page = 1;
    public $page_count = 1;
    // тут будет номер самого первого выводимого на экран изображения на данной странице
    public $first_record_num = 1;

    private $existing_params;
    private $cur = 1;

    // конктруктор получает на вход количество картинок всего и набор имён гет параметров что тоже надо отобразить в url
    function __construct(int $record_count, array $existing_params = [])
    {
        $this->page_count = ceil($record_count / \Settings\RECORDS_ON_PAGE);

        // номер страницы, на которой находимся - в гет параметре
        $page_num = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
        if ($page_num < 1)
            $page_num = 1;
        if ($page_num > $this->page_count)
            $page_num = $this->page_count;

        $this->current_page = $page_num;

        // Номер первого изображения
        $this->first_record_num = ($page_num - 1) * \Settings\RECORDS_ON_PAGE;
        $this->existing_params = $existing_params;
    }

    function current()
    {
        return \Helpers\get_GET_params($this->existing_params, ['page' => $this->cur]);
    }
    function next()
    {
        $this->cur ++;
    }
    function rewind()
    {
        $this->cur = 1;
    }
    function valid()
    {
        return 1 <= $this->cur && $this->cur <= $this->page_count;
    }
    function key()
    {
        return $this->cur;
    }
}