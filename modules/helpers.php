<?php
// это модуль в который мы будем выносить некоторые вспомогательные функции
namespace Helpers {
    // функция получает контекст вызова шаблона и имя шаблона, и просто должна распаковать контекст и require шаблон
    function render(string $template, array $context) {
        global $base_path;
        extract($context);
        require $base_path . '\modules\templates\\' . $template . '.php';
    }

    // а эта функция - получает имя шаблона фрагмента - возвращает путь к нему. вот так просто.
    function get_fragment_path(string $fragment): string {
        global $base_path;
        return $base_path . '\modules\templates\\' . $fragment . '.inc.php';
    }

    // эта функция соединяет с базой данных и возвращает объект, представляющий это соединение
    function connect_to_db() {
        // сформируем строку с настройками соединения
        $conn_str = 'mysql:host=' . \Settings\DB_HOST . ';dbname=' . \Settings\DB_NAME . ';charset=utf8';
        return new \PDO($conn_str, \Settings\DB_USERNAME, \Settings\DB_PASSWORD);
    }

    // функция принимает массив именами существующих гет-параметров, и с новыми, объединяет их в строку с & и ?
    function get_GET_params(array $existing_param_names, array $new_params = []): string {
        $new_array = [];
        foreach ($existing_param_names as $name)
            if (!empty($_GET[$name]))
                $new_array[] = $name . '=' . urlencode($_GET[$name]);
        foreach ($new_params as $name => $value)
            $new_array[] = $name . '=' .urlencode($value);
        // с помощью Implode соедимим элементы массива в строку
        $string_return = implode('&', $new_array);
        // если сто=рока не пустая - вопрос в начале
        if ($string_return)
            $string_return = '?' . $string_return;
        return $string_return;
    }

    function get_formatted_timestamp(string $timestamp): string {
        return strftime('%d.%m.%Y %H:%M:%S', strtotime($timestamp));
    }

    function redirect(string $url, int $status = 302) {
        header('Location: ' . $url, TRUE, $status);
    }

    function show_errors(string $fld_name, array $form_data) {
        if (isset($form_data['__errors'][$fld_name]))
            echo '<div class="error">' .
                $form_data['__errors'][$fld_name] . '</div>';
    }

}
