<?php

class DashboardController {

    public function index() {
        // Vérifier si l'utilisateur est connecté
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: /login");
            exit;
        }

        // Charger la vue du tableau de bord
        require_once __DIR__ . '/../views/user/dashboard.php';
    }
}
?>