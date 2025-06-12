<?php
include("includes/db.php");

$query = "SELECT * FROM activites WHERE date_activite >= CURDATE() ORDER BY date_activite ASC LIMIT 3";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Maison de la Jeunesse - Accueil</title>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background: #f9fafb;
            color: #333;
            line-height: 1.6;
        }
        /* Header */
       
        section.activities h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            color: #0073aa;
            border-bottom: 3px solid #0073aa;
            display: inline-block;
            padding-bottom: 6px;
        }
        .activity-card {
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .activity-card h3 {
            color: #005177;
            font-size: 1.3rem;
        }
        .activity-card p {
            color: #555;
            font-size: 1rem;
        }
        .activity-date {
            font-size: 0.9rem;
            color: #999;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        /* Galerie d'images */
        section.gallery {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        section.gallery h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            color: #0073aa;
            border-bottom: 3px solid #0073aa;
            display: inline-block;
            padding-bottom: 6px;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
            gap: 20px;
        }
        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 7px rgba(0,0,0,0.12);
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .gallery-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        /* Footer */
        footer {
            background-color: #0073aa;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        /* Bouton retour en haut */
        #scrollTopBtn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background-color: #0073aa;
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: background-color 0.3s ease;
        }
        #scrollTopBtn:hover {
            background-color: #005177;
        }
        /* Responsive */
        @media (max-width: 768px) {
            nav ul {
                gap: 15px;
            }
            header {
                flex-direction: column;
                gap: 15px;
                padding: 20px;
            }
            .activity-card {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<?php  include("includes/header.php"); ?>


<main>

<section class="activities">
    <h2><i class="fas fa-calendar-day"></i> Prochaines Activités</h2>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($activite = $result->fetch_assoc()) {
            ?>
            <div class="activity-card">
                <h3><?= htmlspecialchars($activite['titre']) ?></h3>
                <p><?= nl2br(htmlspecialchars($activite['description'])) ?></p>
                <div class="activity-date"><i class="fas fa-clock"></i> <?= $activite['date_activite'] ?></div>
            </div>
            <?php
        }
    } else {
        echo "<p>Aucune activité prévue pour le moment.</p>";
    }
    ?>
</section>

<section class="gallery">
    <h2><i class="fas fa-camera-retro"></i> Galerie</h2>
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="assets/images/image1.png" alt="Photo 1" />
        </div>
        <div class="gallery-item">
            <img src="assets/images/image.png" alt="Photo 2" />
        </div>
        <div class="gallery-item">
            <img src="assets/images/image3.png" alt="Photo 3" />
        </div>
    </div>
</section>

</main>

<?php  include("includes/footer.php"); ?>


