<?php
session_start();
if (!isset($_SESSION["membre_id"])) {
    header("Location: ../login.php");
    exit;
}

include("../includes/db.php");

$succes = "";
$erreur = "";

// Récupérer la liste des salles
$salles_result = $conn->query("SELECT id, nom, capacite FROM salles");

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membre_id = $_SESSION["membre_id"];
    $salle_id = intval($_POST["salle_id"]);
    $date_reservation = $_POST["date_reservation"];
    $heure_debut = $_POST["heure_debut"];
    $heure_fin = $_POST["heure_fin"];

    // Vérification de la disponibilité (à implémenter)
    
    $stmt = $conn->prepare("INSERT INTO reservations (membre_id, salle_id, date_reservation, heure_debut, heure_fin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $membre_id, $salle_id, $date_reservation, $heure_debut, $heure_fin);

    if ($stmt->execute()) {
        $succes = "Réservation effectuée avec succès!";
    } else {
        $erreur = "Une erreur s'est produite lors de la réservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation | Maison de la Jeunesse</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #f5f9fc 0%, #e6f2f8 100%);
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 115, 170, 0.1);
            width: 100%;
            max-width: 500px;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 115, 170, 0.2);
        }
        
        .reservation-form h1 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--bleu-principal);
            font-size: 28px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--bleu-principal);
        }
        
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus,
        .input-group select:focus {
            border-color: var(--bleu-principal);
            box-shadow: 0 0 0 3px rgba(0, 115, 170, 0.2);
            outline: none;
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: var(--bleu-principal);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        button[type="submit"]:hover {
            background: var(--bleu-fonce);
            transform: translateY(-2px);
        }
        
        button[type="submit"]::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%, -50%);
            transform-origin: 50% 50%;
        }
        
        button[type="submit"]:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .error-message {
            color: #d9534f;
            background-color: #f8d7da;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="main">
    <div class="container">
        <form method="POST" class="reservation-form">
            <h1><i class="fas fa-calendar-check"></i> Réservation de salle</h1>
            
            <?php if (!empty($succes)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $succes; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($erreur)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $erreur; ?>
                </div>
            <?php endif; ?>
            
            <div class="input-group">
                <label for="salle_id"><i class="fas fa-door-open"></i> Salle</label>
                <select name="salle_id" id="salle_id" required>
                    <option value="">-- Choisir une salle --</option>
                    <?php
                    while ($row = $salles_result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . " (Capacité: " . $row["capacite"] . ")</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="input-group">
                <label for="date_reservation"><i class="fas fa-calendar-day"></i> Date de réservation</label>
                <input type="date" id="date_reservation" name="date_reservation" required>
            </div>
            
            <div class="input-group">
                <label for="heure_debut"><i class="fas fa-clock"></i> Heure de début</label>
                <input type="time" id="heure_debut" name="heure_debut" required>
            </div>
            
            <div class="input-group">
                <label for="heure_fin"><i class="fas fa-clock"></i> Heure de fin</label>
                <input type="time" id="heure_fin" name="heure_fin" required>
            </div>
            
            <button type="submit"><i class="fas fa-bookmark"></i> Réserver</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>