<?php

require_once '../app/models/Consultation.php';

class ConsultationController {

    // Afficher la liste des patients
public function index() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_patient = $_POST['consultationPatientId'] ?? '';
        $id_user = $_POST['consultationUser'] ?? '';
        $symptome= $_POST['consultationSymptomes'] ?? '';
        $dignostic = $_POST['consultationDiagnostic'] ?? '';
        $traitement = $_POST['consultationTraitement'] ?? '';

        if ($id_patient && $id_user && $symptome && $dignostic && $traitement){
             Consultation::ajouter($id_patient, $id_user, $symptome, $dignostic, $traitement);
            header("Location: dashboard");
            exit;
        }
    }
   
    require_once __DIR__ . '/../views/user/dashboard.php';
}

public function imprimer($id) {
    $consultation = Consultation::getByIdWithDetails($id); // À créer si besoin
    if (!$consultation) {
        echo "Consultation introuvable.";
        return;
    }
   require_once __DIR__ . '/../views/consultation/imprimer.php';
    if (isset($_GET['ajax'])) {
        echo "<script>window.print();</script>";
    }
}

    // Ajouter un patient

    // Modifier un patient
    public function modifier($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_patient = isset($_POST['consultationPatientId']) ? trim($_POST['consultationPatientId']) : '';
            $id_user = isset($_POST['consultationUser']) ? trim($_POST['consultationUser']) : '';
            $symptome = isset($_POST['consultationSymptomes']) ? trim($_POST['consultationSymptomes']) : '';
            $diagnostic = isset($_POST['consultationDiagnostic']) ? trim($_POST['consultationDiagnostic']) : '';
            $traitement = isset($_POST['consultationTraitement']) ? trim($_POST['consultationTraitement']) : '';

            if (Consultation::modifier($id, $id_patient, $id_user, $symptome, $diagnostic, $traitement)) {
                header("Location: /gestion_sante/dashboard");
                exit;
            } else {
                echo "Erreur lors de la modification du patient.";
            }
        } else {
            // Récupérer les infos du patient pour pré-remplir le formulaire
            $consultations = Consultation::getAll();
            $consultation = null;
            foreach ($consultations as $p) {
                if ($p['id'] == $id) {
                    $consultation = $p;
                    break;
                }
            }
             require_once __DIR__ . '/../views/user/dashboard.php';
        }
    }

    // Supprimer un patient
    public function supprimer($id) {
        if (Consultation::supprimer($id)) {
            header("Location: /gestion_sante/dashboard");
            exit;
        } else {
            echo "Erreur lors de la suppression du patient.";
        }
    }
}