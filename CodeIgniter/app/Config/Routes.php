<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('contact', 'ContactController::index'); // Route to show the form
$routes->post('send-email', 'ContactController::sendEmail'); // Route to handle form submission


