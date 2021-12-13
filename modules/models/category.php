<?php
namespace Models;
// класс модель для работы с таблицей категорий
class Category extends \Models\Model {
    protected const TABLE_NAME = 'categories';
    // сортируем по алфавиту
    protected const DEFAULT_ORDER = 'name';
    // никаких связей не имеется
}