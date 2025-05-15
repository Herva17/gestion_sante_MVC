<?php
require_once '../config/database.php';
require_once '../app/Controller/UserController.php';
require_once '../app/Controller/DashboardController.php';
require_once '../app/Controller/PatientController.php';

// Normaliser l'URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/gestion_sante', '', $uri);

// Routage simple
if ($uri === '/login') {
    $controller = new UserController();
    $controller->login();
} elseif ($uri === '/dashboard') {
    $controller = new DashboardController();
    $controller->index();
} elseif ($uri === '/patients') {
    $controller = new PatientController();
    $controller->index();
} elseif ($uri === '/patients/supprimer' && isset($_GET['id'])) {
    $controller = new PatientController();
    $controller->supprimer($_GET['id']);
} elseif ($uri === '/patients/modifier' && isset($_GET['id'])) {
    $controller = new PatientController();
    $controller->modifier($_GET['id']);
} else {
    // Gestion des pages non trouvées
    http_response_code(404);
    echo "Page non trouvée";
}
?>