<?php
namespace Controllers;
class Account extends BaseController {
    private function check_user(string $username) {
        $users = new \Models\User();
        $user = $users->get_or_404($username, 'name', 'id');
        if (!($this->current_user &&
            ($this->current_user['id'] == $user['id'] ||
            $this->current_user['admin'])))
            throw new Page403Exception();
    }

    function delete(string $username) {
        $this->check_user($username);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $users = new \Models\User();
            $users->delete($username, 'name');
            unset ($_SESSION['current_user']);
            session_destroy();
            \Helpers\redirect('/');
        } else {
            $ctx = ['site_title' => 'Удаление пользователя'];
            $this->render('user_delete', $ctx);
        }
    }

    function edit(string $username) {
        $this->check_user($username);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_form =
                \Forms\User::get_normalized_data($_POST);
            if (!isset($user_form['__errors'])) {
                $user_form =
                    \Forms\User::get_prepared_data($user_form);
                $users = new \Models\User();
                $users->update($user_form, $username, 'name');
                \Helpers\redirect('/users/' . $username);
            }
        } else {
            $users = new \Models\User();
            $user = $users->get_or_404($username, 'name');
            $user_form =
                \Forms\User::get_initial_data($user);
        }
        $ctx = ['form' => $user_form,
            'site_title' => 'Правка пользователя'];
        $this->render('user_edit', $ctx);
    }

    function edit_password(string $username) {
        $this->check_user($username);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password_form =
                \Forms\Password::get_normalized_data($_POST);
            if (!isset($password_form['__errors'])) {
                $password_form =
                    \Forms\Password::get_prepared_data($password_form);
                $users = new \Models\User();
                $users->update($password_form, $username, 'name');
                \Helpers\redirect('/users/' . $username);
            }
        } else
            $password_form = \Forms\Password::get_initial_data();
        $ctx = ['form' => $password_form,
            'site_title' => 'Правка пароля пользователя'];
        $this->render('user_password_edit', $ctx);
    }
}
