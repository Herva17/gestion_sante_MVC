<?php

require_once '../config/database.php';

class Patient {

    // Ajouter un patient
    public static function ajouter($nom, $prenom, $sexe, $date_naissance, $telephone, $adresse) {
        try {
            $pdo = Connexion::getInstance();
            $query = "INSERT INTO patients (nom, prenom, sexe, date_naissance, telephone, adresse, created_at) 
                      VALUES (:nom, :prenom, :sexe, :date_naissance, :telephone, :adresse, NOW())";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':sexe', $sexe);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':adresse', $adresse);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        }
    }

    // Sélectionner tous les patients
    public static function getAll() {
        try {
            $pdo = Connexion::getInstance();
            $query = "SELECT * FROM patients ORDER BY created_at DESC";
            $stmt = $pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return [];
        }
    }

    // Modifier un patient
    public static function modifier($id, $nom, $prenom, $sexe, $date_naissance, $telephone, $adresse) {
        try {
            $pdo = Connexion::getInstance();
            $query = "UPDATE patients SET nom = :nom, prenom = :prenom, sexe = :sexe, date_naissance = :date_naissance, 
                      telephone = :telephone, adresse = :adresse WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':sexe', $sexe);
            $stmt->bindParam(':date_naissance', $date_naissance);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':adresse', $adresse);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un patient
    public static function supprimer($id) {
        try {
            $pdo = Connexion::getInstance();
            $query = "DELETE FROM patients WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        }
    }
}