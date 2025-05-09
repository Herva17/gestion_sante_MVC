<?php
require_once '../config/database.php';

class User {

    public static function authentifier($email, $mot_de_passe) {
        global $pdo;

        try {
            // Vérification des entrées
            if (empty($email) || empty($mot_de_passe)) {
                throw new Exception("L'email et le mot de passe sont requis.");
            }

            // Préparation de la requête
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Récupération de l'utilisateur
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe (non haché)
            if ($user && $mot_de_passe === $user['mot_de_passe']) {
                return $user; // Utilisateur authentifié
            }

            // Si l'authentification échoue
            return false;

        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            // Gestion des autres erreurs
            error_log("Erreur : " . $e->getMessage());
            return false;
        }
    }
}
?>