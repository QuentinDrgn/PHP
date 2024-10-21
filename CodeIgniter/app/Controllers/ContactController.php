<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact'); // Render the contact form view
    }

    public function sendEmail()
    {
        if ($this->request->getMethod() === 'post') {
            $fromEmail = $this->request->getPost('email');
            $message = $this->request->getPost('message');

            // Validate email and message
            if (filter_var($fromEmail, FILTER_VALIDATE_EMAIL) && !empty($message)) {
                // Load the email service
                $email = Services::email();

                // Configure email properties
                $email->setFrom($fromEmail);
                $email->setTo('drtoxiz@gmail.com'); // Your destination email
                $email->setSubject('Contact Form Message');
                $email->setMessage(htmlspecialchars($message));

                // Send email
                if ($email->send()) {
                    return "Message sent successfully!";
                } else {
                    return "Failed to send the message." . $email->printDebugger(); // Debugging output
                }
            } else {
                return "Invalid email or message.";
            }
        }

        return view('contact'); // Show the form if the method is not POST
    }
}
