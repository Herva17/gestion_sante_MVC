<?php

require_once '../config/database.php';

class Consultation {

    // Ajouter un patient
    public static function ajouter($id_patient, $id_user, $symptome, $diagnostic, $traitement) {
        try {
            $pdo = Connexion::getInstance();
            $query = "INSERT INTO consultations (patient_id ,user_id, symptomes, diagnostic, traitement, date_cons) 
                      VALUES (:patient_id, :user_id, :symptomes, :diagnostic, :traitement, NOW())";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':patient_id', $id_patient);
            $stmt->bindParam(':user_id', $id_user);
            $stmt->bindParam(':symptomes', $symptome);
            $stmt->bindParam(':diagnostic', $diagnostic);
            $stmt->bindParam(':traitement', $traitement);
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
            $query = "SELECT * FROM consultations ORDER BY date_cons DESC";
            $stmt = $pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return [];
        }
    }

    public static function getAllWithDetails() {
    try {
        $pdo = Connexion::getInstance();
        $query = "SELECT 
                    consultations.id,
                    users.nom AS user_nom,
                    users.prenom AS user_prenom,
                    patients.nom AS patient_nom,
                    patients.prenom AS patient_prenom,
                    consultations.symptomes,
                    consultations.diagnostic,
                    consultations.traitement,
                    consultations.date_cons
                  FROM patients
                  INNER JOIN consultations ON patients.id = consultations.patient_id
                  INNER JOIN users ON users.id = consultations.user_id
                  ORDER BY consultations.date_cons DESC";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur PDO : " . $e->getMessage());
        return [];
    }
}

public static function getByIdWithDetails($id) {
    try {
        $pdo = Connexion::getInstance();
        $query = "SELECT 
                    consultations.id,
                    users.nom AS user_nom,
                    users.prenom AS user_prenom,
                    patients.nom AS patient_nom,
                    patients.prenom AS patient_prenom,
                    consultations.symptomes,
                    consultations.diagnostic,
                    consultations.traitement,
                    consultations.date_cons
                  FROM patients
                  INNER JOIN consultations ON patients.id = consultations.patient_id
                  INNER JOIN users ON users.id = consultations.user_id
                  WHERE consultations.id = :id
                  LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur PDO : " . $e->getMessage());
        return false;
    }
}

    // Modifier un patient
    public static function modifier($id, $id_patient, $id_user, $symptome, $diagnostic, $traitement) {
        try {
            $pdo = Connexion::getInstance();
            $query = "UPDATE consultations SET patient_id = :patient_id, user_id= :user_id, symptomes = :symptomes, diagnostic= :diagnostic, traitement = :traitement, 
                      WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':patient_id', $id_patient);
            $stmt->bindParam(':user_id', $id_user);
            $stmt->bindParam(':symptomes', $symptome);
            $stmt->bindParam(':diagnostic', $diagnostic);
            $stmt->bindParam(':traitement', $traitement);
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
            $query = "DELETE FROM consultations WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        }
    }
}