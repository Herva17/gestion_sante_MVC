<?php
require_once '../config/database.php';
require_once '../app/Controller/UserController.php';
require_once '../app/Controller/DashboardController.php';

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
} else {
    // Gestion des pages non trouvées
    http_response_code(404);
    echo "Page non trouvée";
}
?>