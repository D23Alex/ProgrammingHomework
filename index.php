<?php
$base_path = __DIR__ . '\\';
// подключим модуль настроек
require_once $base_path . 'modules\settings.php';

// реализуем автоподключение модулей. Все модули реализованы в виде классов и находятся в папке modules.
// пространства имён совпадают с иерархией папок
function my_autoloader(string $class_name) {
    global $base_path;
    require_once $base_path . 'modules\\' . $class_name . '.php';
}
spl_autoload_register('my_autoloader');

class Page404Exception extends Exception {}

function exception_handler($e) {
    // будем обращаться к контроллеру
    $ctr = new \Controllers\Error();
    // если объект исключения был создан на основе класса 404, то вызываем метод контроллера 404, иначе 503
    if ($e instanceof Page404Exception)
        $ctr->page404();
    else
        $ctr->page503($e);
}
set_exception_handler('exception_handler');

// теперь надо подключить роутер и провести маршрутизацию
require_once $base_path . 'modules\router.php';