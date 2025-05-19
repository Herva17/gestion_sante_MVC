<?php

require_once '../app/models/Patient.php';

class PatientController {

    // Afficher la liste des patients
public function index() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $sexe = $_POST['sexe'] ?? '';
        $date_naissance = $_POST['date_naissance'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $adresse = $_POST['adresse'] ?? '';

        if ($nom && $prenom && $sexe && $date_naissance && $telephone && $adresse) {
            Patient::ajouter($nom, $prenom, $sexe, $date_naissance, $telephone, $adresse);
            header("Location: dashboard");
            exit;
        }
    }
   
    require_once __DIR__ . '/../views/user/dashboard.php';
}

    // Ajouter un patient
    public function ajouter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
            $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
            $sexe = isset($_POST['sexe']) ? trim($_POST['sexe']) : '';
            $date_naissance = isset($_POST['date_naissance']) ? trim($_POST['date_naissance']) : '';
            $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
            $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';

            if (empty($nom) || empty($prenom) || empty($sexe) || empty($date_naissance) || empty($telephone) || empty($adresse)) {
                echo "Veuillez remplir tous les champs.";
                return;
            }

            if (Patient::ajouter($nom, $prenom, $sexe, $date_naissance, $telephone, $adresse)) {
                header("Location: dashboard");
                exit;
            } else {
                echo "Erreur lors de l'ajout du patient.";
            }
        }
        require_once __DIR__ . '/../views/user/dashboard.php';
    }

    // Modifier un patient
    public function modifier($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
            $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
            $sexe = isset($_POST['sexe']) ? trim($_POST['sexe']) : '';
            $date_naissance = isset($_POST['date_naissance']) ? trim($_POST['date_naissance']) : '';
            $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
            $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';

            if (Patient::modifier($id, $nom, $prenom, $sexe, $date_naissance, $telephone, $adresse)) {
                header("Location: /gestion_sante/dashboard");
                exit;
            } else {
                echo "Erreur lors de la modification du patient.";
            }
        } else {
            // Récupérer les infos du patient pour pré-remplir le formulaire
            $patients = Patient::getAll();
            $patient = null;
            foreach ($patients as $p) {
                if ($p['id'] == $id) {
                    $patient = $p;
                    break;
                }
            }
             require_once __DIR__ . '/../views/user/dashboard.php';
        }
    }

    // Supprimer un patient
    public function supprimer($id) {
        if (Patient::supprimer($id)) {
            header("Location: /gestion_sante/dashboard");
            exit;
        } else {
            echo "Erreur lors de la suppression du patient.";
        }
    }
}