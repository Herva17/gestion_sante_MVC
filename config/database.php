<?php
class Connexion {
    private static $instance = null;

    private function __construct() {
        // Empêche l’instanciation directe
    }

    public static function getInstance() {
        if (self::$instance === null) {
            $host = 'localhost';
            $dbname = 'gestion_sante';
            $username = 'root';
            $password = '';

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}

