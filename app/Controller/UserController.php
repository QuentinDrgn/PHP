<?php

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller {
    public function index () {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $this->view('users/index', ['users' => $users]);
    }

    public function signup() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $userModel = new User();
            $userModel->createUser($name, $email, $password);

            if (empty($name) || empty($email) || empty($password)) {
                echo "All fields are required!";
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new User();
            $userCreated = $userModel->createUser($name, $email, $hashedPassword);

            if ($userCreated) {
                header("Location: /curriculum");
            } else {
                echo "Error creating user!";
            }
        }
    }
}