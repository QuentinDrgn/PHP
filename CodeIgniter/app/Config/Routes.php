<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('contact', 'ContactController::index'); // Route to show the form
$routes->post('send-email', 'ContactController::sendEmail'); // Route to handle form submission
$routes->get('portfolio', 'PortfolioController::index'); // Route to show the portfolio
$routes->get('login', 'LoginController::index'); // Route to show the login form
$routes->post('login', 'LoginController::login'); // Route to handle login form submission
$routes->get('logout', 'LoginController::logout'); // Route to handle logout
$routes->get('profil', 'ProfilController::index'); // Route to show the user profile
$routes->get('admin', 'AdminController::index'); // Route to show the admin panel
$routes->get('curriculum', 'CurriculumController::index'); // Route to show the curriculum
$routes->post('saveStyle', 'CurriculumController::saveStyle'); // Route to handle style settings form submission
$routes->post('saveProject', 'PortfolioController::saveProject'); // Route to handle project form submission
$routes->post('curriculum', 'CurriculumController::saveCurriculum'); // Route to handle curriculum form submission


