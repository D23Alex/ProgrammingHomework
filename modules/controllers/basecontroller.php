<?php
// это будет класс-предок для всех последующих контроллеров.
// он будет поддерживать функции "добавить контекст" и "рендер" - то есть вызов шаблона с передаваемым контекстом
namespace Controllers;
// в модуль helpers мы будем относить некоторые функции
require_once $base_path . 'modules\helpers.php';
class BaseController {
    protected function context_append(array &$context) {
        if (isset($this->current_user))
            $context['__current_user'] = $this->current_user;
    }
    // получаем имя шаблона и контекст - надо зарендерить
    protected function render(string $template, array $context) {
        // добавим доп. контекст
        $this->context_append($context);
        // вызовем функцию рендера, которая хранится в помошнике
        \Helpers\render($template, $context);
    }

    function __construct() {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if (isset($_SESSION['current_user'])) {
            $users = new \Models\User();
            $this->current_user =
                $users->get_or_404($_SESSION['current_user']);
        } else
            session_destroy();
    }
}