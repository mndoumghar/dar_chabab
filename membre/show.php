<?php
session_start();
if (!isset($_SESSION["membre_id"])) {
    header("Location: ../login.php");
    exit;
}

// Use correct path to db.php based on your file structure
include(__DIR__ . "/../includes/db.php");

// Check if connection exists
if (!isset($conn)) {
    die("Erreur de connexion à la base de données");
}

// Récupérer toutes les réservations
$reservations_query = "
    SELECT r.id, r.date_reservation, r.heure_debut, r.heure_fin, 
           s.nom AS salle_nom, s.capacite,
           m.nom AS membre_nom
    FROM reservations r
    JOIN salles s ON r.salle_id = s.id
    JOIN membres m ON r.membre_id = m.id
    ORDER BY r.date_reservation DESC, r.heure_debut DESC
";
$reservations_result = $conn->query($reservations_query);

// Handle query error
if (!$reservations_result) {
    die("Erreur de requête: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations | Maison de la Jeunesse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bleu-principal: #0073aa;
            --bleu-fonce: #005177;
            --bleu-clair: #e6f2f8;
        }
        
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f9fc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main {
            flex: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 115, 170, 0.1);
        }
        
        h1 {
            color: var(--bleu-principal);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .reservations-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .reservations-table th, 
        .reservations-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .reservations-table th {
            background-color: var(--bleu-clair);
            color: var(--bleu-fonce);
            font-weight: 600;
        }
        
        .reservations-table tr:hover {
            background-color: #f5f9fc;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #d4edda;
            color: #28a745;
        }
        
        .status-past {
            background-color: #f8d7da;
            color: #dc3545;
        }
        
        .no-reservations {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .cancel-btn {
            background-color: #f8d7da;
            color: #dc3545;
        }
        
        .cancel-btn:hover {
            background-color: #f1b0b7;
        }
        
        @media (max-width: 768px) {
            .reservations-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
<?php include(__DIR__ . "/../includes/header.php"); ?>

<div class="main">
    <div class="container">
        <h1><i class="fas fa-calendar-alt"></i> Mes Réservations</h1>
        
        <?php if ($reservations_result->num_rows > 0): ?>
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>Salle</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Capacité</th>
                        <th>Réservé par</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($reservation = $reservations_result->fetch_assoc()): 
                        $current_date = date('Y-m-d');
                        $current_time = date('H:i:s');
                        $is_past = ($reservation['date_reservation'] < $current_date) || 
                                  ($reservation['date_reservation'] == $current_date && 
                                   $reservation['heure_debut'] < $current_time);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['salle_nom']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($reservation['date_reservation'])); ?></td>
                            <td><?php echo substr($reservation['heure_debut'], 0, 5) . ' - ' . substr($reservation['heure_fin'], 0, 5); ?></td>
                            <td><?php echo $reservation['capacite']; ?> personnes</td>
                            <td><?php echo htmlspecialchars($reservation['membre_nom']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $is_past ? 'status-past' : 'status-active'; ?>">
                                    <?php echo $is_past ? 'Terminé' : 'À venir'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!$is_past): ?>
                                    <button class="action-btn cancel-btn" 
                                            onclick="confirmCancel(<?php echo $reservation['id']; ?>)">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-reservations">
                <i class="fas fa-calendar-times" style="font-size: 50px; margin-bottom: 20px;"></i>
                <h3>Aucune réservation trouvée</h3>
                <p>Vous n'avez pas encore effectué de réservation.</p>
                <a href="reserver.php" style="color: var(--bleu-principal);">Faire une réservation</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(__DIR__ . "/../includes/footer.php"); ?>

<script>
    function confirmCancel(reservationId) {
        if (confirm("Êtes-vous sûr de vouloir annuler cette réservation ?")) {
            window.location.href = "cancel_reservation.php?id=" + reservationId;
        }
    }
</script>
</body>
</html>