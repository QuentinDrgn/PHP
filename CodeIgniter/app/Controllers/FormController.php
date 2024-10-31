<?php

namespace App\Controllers;

use CodeIgniter\Controller;
class FormController extends Controller
{
    public function index()
    {
        return view('curriculum'); // Renders the curriculum form view
    }

    // Example Controller Function in CodeIgniter
public function saveChanges()
{
    // Set validation rules
    $validationRules = [
        'name' => 'required|is_unique[table.name]',
        'email' => 'required|valid_email|is_unique[table.email]',
        'phone' => 'required|is_unique[table.phone]'
    ];

    if (!$this->validate($validationRules)) {
        // If validation fails, send error response
        echo json_encode([
            'status' => 'error',
            'errors' => $this->validator->getErrors()
        ]);
    } else {
        // If validation passes, save the changes and send success response
        // Save data logic here...
        echo json_encode(['status' => 'success']);
    }
}
}


