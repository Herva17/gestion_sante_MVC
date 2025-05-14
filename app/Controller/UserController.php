<?php
require_once '../app/models/User.php';

class UserController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valider les données du formulaire de connexion
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $mot_de_passe = isset($_POST['mot_de_passe']) ? trim($_POST['mot_de_passe']) : '';

            // Vérification des champs vides
            if (empty($email) || empty($mot_de_passe)) {
                echo "Veuillez remplir tous les champs.";
                return;
            }

            // Vérifier les informations dans la base de données via la méthode statique authentifier
            $user = User::authentifier($email, $mot_de_passe);
            if ($user) {
                // Démarrer une session et stocker les informations utilisateur
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['user_prenom'] = $user['prenom'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // Rediriger vers la page d'accueil après connexion
                header("Location: dashboard");
                exit;
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        }

        // Charger la vue de connexion
        require_once __DIR__ . '/../views/user/login.php';
    }
}
