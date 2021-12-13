<?php
namespace Controllers;
// у класса 2 метода - 404 и 505. они вызывают одноимённые шаблоны с необходимым контекстом.
class Error extends BaseController {
    function page404() {
        $this->render('404',[]);
    }
    function page503($e) {
        $ctx = ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()];
        $this->render('503', $ctx);
    }
}