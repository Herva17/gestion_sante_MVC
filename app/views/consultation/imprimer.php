
<?php if (isset($_GET['ajax'])): ?>
<div class="fiche-consultation">
    <div class="fiche-entete">
        <div class="hopital-nom">HÔPITAL GÉNÉRAL DE RÉFÉRENCE</div>
        <div class="hopital-adresse">123, Avenue de la Santé, Ville - Tél : 012 345 678</div>
        <hr>
        <h2>Fiche de Consultation</h2>
        <div class="fiche-meta">
            <strong>Date :</strong> <?= htmlspecialchars($consultation['date_cons']) ?>
        </div>
    </div>
    <div class="fiche-section">
        <div><strong>Patient :</strong> <?= htmlspecialchars($consultation['patient_nom'] . ' ' . $consultation['patient_prenom']) ?></div>
        <div><strong>Médecin :</strong> Dr <?= htmlspecialchars($consultation['user_nom'] . ' ' . $consultation['user_prenom']) ?></div>
    </div>
    <div class="fiche-section">
        <div class="fiche-label">Symptômes :</div>
        <div class="fiche-content"><?= nl2br(htmlspecialchars($consultation['symptomes'])) ?></div>
    </div>
    <div class="fiche-section">
        <div class="fiche-label">Diagnostic :</div>
        <div class="fiche-content"><?= nl2br(htmlspecialchars($consultation['diagnostic'])) ?></div>
    </div>
    <div class="fiche-section">
        <div class="fiche-label">Traitement :</div>
        <div class="fiche-content"><?= nl2br(htmlspecialchars($consultation['traitement'])) ?></div>
    </div>
    <div class="fiche-signature">
        <div>
            <strong>Signature du Médecin</strong>
            <br><br>
            Dr <?= htmlspecialchars($consultation['user_nom'] . ' ' . $consultation['user_prenom']) ?>
        </div>
        <div class="fiche-signature-ligne"></div>
    </div>
</div>
<style>
.fiche-consultation {
    font-family: Arial, sans-serif;
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
    padding: 32px 24px;
}
.hopital-nom {
    font-size: 1.3em;
    font-weight: bold;
    color: #2196F3;
    text-align: center;
    margin-bottom: 2px;
    letter-spacing: 1px;
}
.hopital-adresse {
    text-align: center;
    font-size: 0.95em;
    color: #444;
    margin-bottom: 10px;
}
.fiche-entete h2 {
    color: #2196F3;
    text-align: center;
    margin: 18px 0 8px 0;
}
.fiche-meta {
    text-align: center;
    font-size: 1em;
    color: #444;
    margin-bottom: 18px;
}
.fiche-section {
    margin-bottom: 18px;
}
.fiche-label {
    font-weight: bold;
    color: #333;
    margin-bottom: 2px;
}
.fiche-content {
    background: #f8fafd;
    border-radius: 4px;
    padding: 10px 12px;
    border: 1px solid #e0e0e0;
    min-height: 32px;
    margin-bottom: 4px;
}
.fiche-signature {
    margin-top: 40px;
    text-align: right;
}
.fiche-signature-ligne {
    border-bottom: 1.5px solid #888;
    width: 180px;
    margin: 30px 0 0 auto;
}
@media print {
    body {
        background: #fff !important;
    }
    .fiche-consultation {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
}

.print-btn {
    display: inline-block;
    margin: 24px auto 0 auto;
    padding: 12px 32px;
    background-color: #2196F3;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1.1em;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(33,150,243,0.12);
    transition: background 0.2s, box-shadow 0.2s;
}
.print-btn:hover, .print-btn:focus {
    background-color: #1769aa;
    box-shadow: 0 4px 12px rgba(33,150,243,0.18);
}
@media print {
    .print-btn {
        display: none !important;
    }
}
</style>
<?php endif; ?>