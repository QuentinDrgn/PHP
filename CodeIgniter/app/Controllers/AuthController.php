<?php

//AuthController.php

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function logout()
    {
        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page
        redirect('/');
    }
}