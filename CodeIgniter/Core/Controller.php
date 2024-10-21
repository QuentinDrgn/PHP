<?php 

namespace App\Core;
class Controller {
    public function view($view, $data = []) {
        require_once '../app/Views/' . $view . '.php';
    }

    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        return new $model;
    }

    public function db() {
        require_once '../app/Models/db.php';
        return $pdo;
    }

    public function redirect($url) {
        header('Location: ' . $url);
    }

    public function is_logged_in() {
        return isset($_SESSION['user']);
    }

    public function is_admin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public function is_owner($user_id) {
        return isset($_SESSION['user']) && $_SESSION['user']['id'] === $user_id;
    }

    public function is_logged_out() {
        return !isset($_SESSION['user']);
    }

    public function is_logged_in_redirect($url) {
        if ($this->is_logged_in()) {
            $this->redirect($url);
        }
    }

    public function is_admin_redirect($url) {
        if ($this->is_admin()) {
            $this->redirect($url);
        }
    }

    public function is_owner_redirect($url, $user_id) {
        if ($this->is_owner($user_id)) {
            $this->redirect($url);
        }
    }

    public function is_logged_out_redirect($url) {
        if ($this->is_logged_out()) {
            $this->redirect($url);
        }
    }

    public function is_logged_in_or_redirect($url) {
        if (!$this->is_logged_in()) {
            $this->redirect($url);
        }
    }

    public function is_admin_or_redirect($url) {
        if (!$this->is_admin()) {
            $this->redirect($url);
        }
    }

    public function is_owner_or_redirect($url, $user_id) {
        if (!$this->is_owner($user_id)) {
            $this->redirect($url);
        }
    }

    public function is_logged_out_or_redirect($url) {
        if (!$this->is_logged_out()) {
            $this->redirect($url);
        }
    }

    public function is_logged_in_or_json($json) {
        if (!$this->is_logged_in()) {
    }
    }

}