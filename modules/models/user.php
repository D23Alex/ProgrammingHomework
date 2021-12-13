<?php
namespace Models;
// класс модель для работы с таблицей юзеров
class User extends \Models\Model {
    protected const TABLE_NAME = 'users';
    // сортируем по алфавиту
    protected const DEFAULT_ORDER = 'name';
    // никаких связей не имеется
}