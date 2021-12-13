<?php
namespace Models;
// подключим вспомогательный модуль
require_once $base_path . 'modules\helpers.php';

// класс базовой модели, работающей с базой данных
class Model implements \Iterator {
    // эти константы оставим пустыми и будем заполнять уже в классах - наследниках
    protected const TABLE_NAME = '';
    protected const DEFAULT_ORDER = '';
    // эта константа - ассоциативный массив, ключи которого имеют имена привязанных к таблице таблиц,
    // и хранят ассоциативный массив с параметрами связи
    protected const RELATIONS = [];

    // есть ли соединение и сколько объектов использует это соединение
    // в этом свойстве хранится объект соединения.
    static private $connection = NULL;
    static private $connection_count = 0;

    private $record = 0;
    private $query = NULL;

    // конструктор класса - объявляет соединение и увеличивает счётчик на 1
    function __construct() {
        // если объект соединения не существует - создать
        if (!self::$connection)
            self::$connection = \Helpers\connect_to_db();
        // увеличим счётчик
        self::$connection_count ++;
    }

    // деструктор - уменьшает на 1 счётчик и если оказывается что никто не использует соединение - разрыавем соединение
    function __destruct() {
        self::$connection_count --;
        if (self::$connection_count == 0)
            self::$connection = NULL;
    }

    // функция run получает на вход запрос и параметры. Если уже существует запрос - его стираем
    // в объекте query подгатавливаем запрос(prepare), проходимся по параметрам, добавляем параметры с помощью bindValue
    function run($sql, $params = NULL) {
        if ($this->query)
            $this->query->closeCursor();
        // с помощью метода prepare Объекта подключения заносим в свойство query наш запрос
        $this->query = self::$connection->prepare($sql);
        // почему-то params поступает в качестве строки
        if ($params) {
            foreach ($params as $key => $value) {
                $k = (is_integer($key)) ? $key + 1 : $key;
                switch (gettype($value)) {
                    case 'integer':
                        $t = \PDO::PARAM_INT;
                        break;
                    case 'boolean':
                        $t = \PDO::PARAM_BOOL;
                        break;
                    case 'NULL':
                        $t = \PDO::PARAM_NULL;
                        break;
                    default:
                        $t = \PDO::PARAM_STR;
                }
                $this->query->bindValue($k, $value, $t);
            }
        }
        // теперь мы полставили все параметры из params в запрос и запрос полностью готов. выполняем запрос.
        $this->query->execute();
    }

    // Эта функция просто формирует запрос из дефолтных параметров, настроек, и заданных составных частей.
    // Затем она вызывает функцию run
    function select($fields = '*', $links = NULL, $where = '', $params = NULL, $order = '', $offset = NULL, $limit = NULL, $group = '', $having = '') {
        // переменная s - будущая строка запроса
        $s = 'SELECT ' . $fields . ' FROM ' . static::TABLE_NAME;
        // если заданы свзяи - то мы, получая тип связи из статического свойства RELATIONS[данная таблица] узнаем,
        // с какой таблицей и каким способом связана.
        if ($links)
            foreach ($links as $ext_table) {
                // по ключу находим нынешние связи(то есть опции в асс. массиве)
                $rel = static::RELATIONS[$ext_table];
                // почему пустой?
                $s .= ' ' . ((key_exists('type', $rel)) ?
                        $rel['type'] : 'INNER') . ' JOIN ' .  $ext_table .
                    ' ON ' . static::TABLE_NAME . '.' .
                    $rel['external'] . ' = ' . $ext_table . '.' .
                    $rel['primary'];
            }
        if ($where)
            $s .= ' WHERE ' . $where;
        if ($group) {
            $s .= ' GROUP BY ' . $group;
            if ($having) {
                $s .= ' HAVING ' . $having;
            }
        }
        if ($order)
            $s .= ' ORDER BY ' . $order;
        else
            $s .= ' ORDER BY ' . static::DEFAULT_ORDER;

        if ($limit && $offset !== NULL)
            $s .= ' LIMIT ' . $offset . ', ' . $limit;

        $s .= ';';

        // теперь строка SQL запроса готова, и мы можем её посылать уже сделанным методом run
        $this->run($s, $params);
    }

    // реализуем методы интерфейса итератор
    // массив со значениями очередной извлечённой записи храним в this->$record
    function current()
    {
        return $this->record;
    }
    function key()
    {
        return 0;
    }
    function next()
    {
        // результат запроса хранится в this->query. считаем очередную заппись
        $this->record = $this->query->fetch(\PDO::FETCH_ASSOC);
    }
    function rewind()
    {
        // получить первый элемент - так же как и получить любой другой элемент
        $this->record = $this->query->fetch(\PDO::FETCH_ASSOC);
    }
    function valid()
    {
        // так как fetch возвращает false если строки закончились - то то условие корректности - != false
        return $this->record !== FALSE;
    }

    // функция согласно данным ей полям и условию фильтрации возвращает 1 запись
    function get_record($fields = '*', $links = NULL, $where = '', $params = NULL) {
        // обнуляем record
        $this->record = NULL;
        // формируем запрос и выполняем его
        $this->select($fields, $links, $where, $params);
        // возвращаем первую и единственную запсь
        return $this->query->fetch(\PDO::FETCH_ASSOC);
    }

    // функция возвращает 1 запись, значение указанного поля которому равно указанному значению
    function get($value, $key_field = 'id', $fields = '*', $links = NULL) {
        return $this->get_record($fields, $links, $key_field . ' = ?', [$value]);
    }
    // то же самое, что и get, но в случае неудачи возвращает 404
    function get_or_404($value, $key_field = 'id', $fields = '*', $links = NULL) {
        $rec = $this->get($value, $key_field, $fields, $links);
        if ($rec)
            return $rec;
        else
            throw new \Page404Exception();
    }

    protected function before_insert(&$fields) {}

    function insert($fields) {
        static::before_insert($fields);
        $s = 'INSERT INTO ' . static::TABLE_NAME;
        $s2 = $s1 = '';
        foreach ($fields as $n => $v) {
            if ($s1) {
                $s1 .= ', ';
                $s2 .= ', ';
            }
            $s1 .= $n;
            $s2 .= ':' . $n;
        }
        $s .= ' (' . $s1 . ') VALUES (' . $s2 . ');';
        $this->run($s, $fields);
        $id = self::$connection -> lastInsertId();
        //echo $id;
        return $id;
    }

    protected function before_update(&$fields, $value,
                                     $key_field = 'id') {}

    function update($fields, $value, $key_field = 'id') {
        static::before_update($fields, $value, $key_field);
        $s = 'UPDATE ' . static::TABLE_NAME . ' SET ';
        $s1 = '';
        foreach ($fields as $n => $v) {
            if ($s1)
                $s1 .= ', ';
            $s1 .= $n . ' = :' . $n;
        }
        $s .= $s1 . ' WHERE ' . $key_field . ' = :__key;';
        $fields['__key'] = $value;
        $this->run($s, $fields);
    }

    protected function before_delete($value, $key_field = 'id') {}

    function delete($value, $key_field = 'id') {
        static::before_delete($value, $key_field);
        $s = 'DELETE FROM ' . static::TABLE_NAME;
        $s .= ' WHERE ' . $key_field . ' = ?;';
        $this->run($s, [$value]);
    }
}
