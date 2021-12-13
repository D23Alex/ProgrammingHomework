<?php
$request_path = $_GET['route'];
if ($request_path && $request_path[-1] == '/')
    $request_path = substr($request_path, 0,
        strlen($request_path) - 1);
$result = [];
if (preg_match('/^cats\/(\w+)$/', $request_path, $result) === 1) {
    $ctr = new \Controllers\Spending();
    $ctr->by_cat($result[1]);
} else if (preg_match('/^users\/(\w+)$/', $request_path, $result) === 1) {
    $ctr = new \Controllers\Spending();
    $ctr->by_user($result[1]);
}  else if (preg_match('/^(\d+)$/', $request_path, $result) === 1) {
    $index = (integer)$result[1];
    $ctr = new \Controllers\Spending();
    $ctr->item($index);
}  else if (preg_match('/^users\/(\w+)\/pictures\/add$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Spending();
    $ctr->add($result[1]);
} else if (preg_match('/^users\/(\w+)\/pictures\/(\d+)\/edit$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Spending();
    $ctr->edit($result[1], (integer)$result[2]);
} else if (preg_match('/^users\/(\w+)\/pictures\/(\d+)\/delete$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Spending();
    $ctr->delete($result[1], (integer)$result[2]);
} else if (preg_match('/^(\d+)\/comments\/(\d+)\/edit$/',
    $request_path, $result) === 1) {
    $picture_index = (integer)$result[1];
    $comment_index = (integer)$result[2];
    $ctr = new \Controllers\Comments();
    $ctr->edit($picture_index, $comment_index);
} else if (preg_match('/^(\d+)\/comments\/(\d+)\/delete$/',
    $request_path, $result) === 1) {
    $picture_index = (integer)$result[1];
    $comment_index = (integer)$result[2];
    $ctr = new \Controllers\Comments();
    $ctr->delete($picture_index, $comment_index);
} else if (preg_match('/^users\/(\w+)\/account\/delete$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->delete($result[1]);
} else if (preg_match('/^users\/(\w+)\/account\/edit$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->edit($result[1]);
} else if (preg_match('/^users\/(\w+)\/account\/editpassword$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->edit_password($result[1]);
} else if ($request_path == 'login') {
    $ctr = new \Controllers\Login();
    $ctr->login();
} else if ($request_path == 'logout') {
    $ctr = new \Controllers\Login();
    $ctr->logout();
} else if ($request_path == 'spending') {
    $ctr = new \Controllers\Spending();
    $ctr->items_main();
} else if ($request_path == 'register') {
    $ctr = new \Controllers\Login();
    $ctr->register();
} else if ($request_path == '') {
    $ctr = new \Controllers\Spending();
    $ctr->get_started();
} else {
    throw new Page404Exception();
}
