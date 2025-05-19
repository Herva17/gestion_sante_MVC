<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$patients = Patient::getAll();
$consultations = Consultation::getAll();
$details = Consultation::getAllWithDetails();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestion des consultations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #575757;
        }

        .container {
            padding: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h2 {
            margin-top: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            color: white;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        .logout {
            float: right;
            color: white;
            text-decoration: none;
            padding: 14px 20px;
        }

        .logout:hover {
            background-color: #575757;
        }

        /* Styles pour les modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 95%;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style renforcé pour les formulaires dans les modals */
        .modal-content form {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        .modal-content label {
            flex: 1 1 100%;
            font-weight: bold;
            margin-bottom: 4px;
            color: #333;
            letter-spacing: 0.5px;
        }

        .modal-content input[type="text"],
        .modal-content input[type="date"],
        .modal-content select,
        .modal-content textarea {
            flex: 1 1 48%;
            min-width: 0;
            padding: 12px;
            border: 1.5px solid #bdbdbd;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 1em;
            background: #f9f9f9;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .modal-content textarea {
            min-height: 60px;
            resize: vertical;
        }

        .modal-content input[type="text"]:focus,
        .modal-content input[type="date"]:focus,
        .modal-content select:focus,
        .modal-content textarea:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px #c8f7c5;
        }

        .modal-content button[type="submit"] {
            flex: 1 1 100%;
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 4px rgba(76, 175, 80, 0.08);
        }

        .modal-content button[type="submit"]:hover {
            background-color: #388e3c;
            box-shadow: 0 4px 8px rgba(56, 142, 60, 0.12);
        }

        /* Responsive : 1 colonne sur mobile */
        @media (max-width: 700px) {

            .modal-content input[type="text"],
            .modal-content input[type="date"],
            .modal-content select,
            .modal-content textarea {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<!-- Modal pour Fiche Consultation -->
<div id="ficheConsultationModal" class="modal">
    <div class="modal-content" style="max-width:600px;">
        <span class="close" onclick="closeModal('ficheConsultationModal')">&times;</span>
        <div id="ficheConsultationContent">
            <?php if (isset($_GET['ajax'])): ?>
                <h2>Fiche de Consultation</h2>
                <table>
                    <tr>
                        <th>Patient</th>
                        <td><?= htmlspecialchars($consultation['patient_nom'] . ' ' . $consultation['patient_prenom']) ?></td>
                    </tr>
                    <tr>
                        <th>Médecin</th>
                        <td><?= htmlspecialchars($consultation['user_nom'] . ' ' . $consultation['user_prenom']) ?></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><?= htmlspecialchars($consultation['date_cons']) ?></td>
                    </tr>
                    <tr>
                        <th>Symptômes</th>
                        <td><?= htmlspecialchars($consultation['symptomes']) ?></td>
                    </tr>
                    <tr>
                        <th>Diagnostic</th>
                        <td><?= htmlspecialchars($consultation['diagnostic']) ?></td>
                    </tr>
                    <tr>
                        <th>Traitement</th>
                        <td><?= htmlspecialchars($consultation['traitement']) ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <!-- ... version complète HTML pour l'impression directe ... -->
            <?php endif; ?>
        </div>
        <button class="print-btn" onclick="printFiche()">Imprimer</button>
    </div>
</div>

<body>
    <header>
        <h1>Tableau de bord - Gestion des consultations</h1>
    </header>
    <nav>
        <a href="#" onclick="openModal('patientsModal')">Patients</a>
        <a href="#" onclick="openModal('statistiquesModal')">Statistiques</a>
        <a href="login" class="logout">Se déconnecter</a>
    </nav>
    <div class="container">
        <div class="card">
            <h2>Bienvenue, <?= htmlspecialchars($_SESSION['user_nom']) ?></h2>
            <p>Vous êtes connecté en tant que <?= htmlspecialchars($_SESSION['user_role']) ?>.</p>
        </div>

        <!-- Modal pour Ajouter une Consultation -->
        <div id="consultationsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('consultationsModal')">&times;</span>
                <h2>Ajouter une Consultation</h2>
                <form action="consultations" method="POST">
                    <label for="consultationPatientId">Patient :</label>
                    <select id="consultationPatientId" name="consultationPatientId" required>
                        <!-- Exemple de données statiques -->
                        <option value="">-- Sélectionnez un patient --</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= htmlspecialchars($patient['id']) ?>"><?= htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="consultationUser" value="<?= htmlspecialchars($_SESSION['user_id']) ?>" name="consultationUser" required>
                    <label for="consultationSymptomes">Symptômes :</label>
                    <textarea id="consultationSymptomes" name="consultationSymptomes" rows="3" required></textarea>

                    <label for="consultationDiagnostic">Diagnostic :</label>
                    <textarea id="consultationDiagnostic" name="consultationDiagnostic" rows="3" required></textarea>

                    <label for="consultationTraitement">Traitement :</label>
                    <textarea id="consultationTraitement" name="consultationTraitement" rows="3" required></textarea>
                    <button type="submit" class="btn">Enregistrer</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Patient</th>
                            <th>ID Médecin</th>
                            <th>Symptômes</th>
                            <th>Diagnostic</th>
                            <th>Traitement</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultations as $consultation): ?>
                            <!-- Exemple de données statiques -->
                            <tr>
                                <td><?= htmlspecialchars($consultation['id']) ?></td>
                                <td><?= htmlspecialchars($consultation['patient_id']) ?></td>
                                <td><?= htmlspecialchars($consultation['user_id']) ?></td>
                                <td><?= htmlspecialchars($consultation['symptomes']) ?></td>
                                <td><?= htmlspecialchars($consultation['diagnostic']) ?></td>
                                <td><?= htmlspecialchars($consultation['traitement']) ?></td>
                                <td><?= htmlspecialchars($consultation['date_cons']) ?></td>
                                <td>
                                    <a href="" class="btn">Modifier</a>
                                    <a href="" class="btn" style="background-color: #f44336;">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bouton pour ouvrir le modal -->
        <div class="card">
            <h2>Liste des consultations</h2>
            <a href="#" class="btn" onclick="openModal('consultationsModal')">Ajouter une consultation</a>
            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Date</th>
                        <th>Symptômes</th>
                        <th>Diagnostic</th>
                        <th>Traitement</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Exemple de données statiques -->
                    <?php foreach ($details as $lesCons): ?>
                        <tr>
                            <td><?= htmlspecialchars($lesCons['id']) ?></< /td>
                            <td><?= htmlspecialchars($lesCons['patient_nom'] . ' ' . $lesCons['patient_prenom']) ?></td>
                            <td><?= htmlspecialchars($lesCons['user_nom'] . ' ' . $lesCons['user_prenom']) ?></td>
                            <td><?= htmlspecialchars($lesCons['date_cons']) ?></td>
                            <td><?= htmlspecialchars($lesCons['symptomes']) ?></< /</td>
                            <td><?= htmlspecialchars($lesCons['diagnostic']) ?></td>
                            <td><?= htmlspecialchars($lesCons['traitement']) ?></td>
                            <td>
                                <a href="#" class="btn" style="background-color: #2196F3;" onclick="afficherFicheConsultation(<?= $lesCons['id'] ?>); return false;">Imprimer fiche</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal pour Patients -->
        <div id="patientsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('patientsModal')">&times;</span>
                <h2>Gestion des Patients</h2>
                <form action="patients" method="POST">
                    <label for="patientName">Nom :</label>
                    <input type="text" id="patientName" name="nom" required>

                    <label for="patientPrenom">Prénom :</label>
                    <input type="text" id="patientPrenom" name="prenom" required>

                    <label for="patientSexe">Sexe :</label>
                    <select id="patientSexe" name="sexe" required>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>

                    <label for="patientDateNaissance">Date de naissance :</label>
                    <input type="date" id="patientDateNaissance" name="date_naissance" required>

                    <label for="patientTelephone">Téléphone :</label>
                    <input type="text" id="patientTelephone" name="telephone" required>

                    <label for="patientAdresse">Adresse :</label>
                    <input type="text" id="patientAdresse" name="adresse" required>

                    <button type="submit" class="btn">Enregistrer</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>Date de naissance</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- Tableau dynamique -->
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['id']) ?></td>
                                <td><?= htmlspecialchars($patient['nom']) ?></td>
                                <td><?= htmlspecialchars($patient['prenom']) ?></td>
                                <td><?= htmlspecialchars($patient['sexe']) ?></td>
                                <td><?= htmlspecialchars($patient['date_naissance']) ?></td>
                                <td><?= htmlspecialchars($patient['telephone']) ?></td>
                                <td><?= htmlspecialchars($patient['adresse']) ?></td>
                                <td><?= htmlspecialchars($patient['created_at']) ?></td>
                                <td>
                                    <a href="" class="btn">Modifier</a>
                                    <a href="" class="btn" style="background-color: #f44336;">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal pour Statistiques -->
        <div id="statistiquesModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('statistiquesModal')">&times;</span>
                <h2>Statistiques des consultations</h2>
                <p>Graphique ou tableau des consultations par maladie.</p>
            </div>
        </div>

        <script>
            function openModal(modalId) {
                document.getElementById(modalId).style.display = "block";
            }

            function closeModal(modalId) {
                document.getElementById(modalId).style.display = "none";
            }
        </script>
        <script>
            function afficherFicheConsultation(id) {
                // Appel AJAX pour récupérer la fiche (à adapter selon ton backend)
                fetch('consultations/imprimer?id=' + id + '&ajax=1')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('ficheConsultationContent').innerHTML = html;
                        openModal('ficheConsultationModal');
                    });
            }

            function printFiche() {
                var ficheContent = document.getElementById('ficheConsultationContent').innerHTML;
                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Fiche Consultation</title>');
                printWindow.document.write('<style>body{font-family:Arial,sans-serif;margin:40px;}h2{color:#4CAF50;}table{width:100%;border-collapse:collapse;margin-top:20px;}td,th{border:1px solid #ddd;padding:8px;}th{background:#f4f4f4;}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(ficheContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }
        </script>
</body>

</html>