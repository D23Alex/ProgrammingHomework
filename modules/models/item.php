<?php
namespace Models;
class Item extends \Models\Model {
    protected const TABLE_NAME = 'items';
    // сортировка по дате по убыванию(от новых к старым)
    protected const DEFAULT_ORDER = 'uploaded DESC';
    // связи есть - категория и юзер
    protected const RELATIONS =
        ['categories' => ['external' => 'category', 'primary' => 'id'],
            'users' => ['external' => 'user', 'primary' => 'id']];
}