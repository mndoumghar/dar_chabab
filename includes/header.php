<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Dar chabab</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
    <h1><i class="fas fa-users"></i> Dar chabab</h1>
    <nav>
        <ul>
            <li><a href="/dar_chabab" class="active"><i class="fas fa-home"></i> Accueil</a></li>
            <li><a href="/dar_chabab/membre/reserver.php"><i class="fas fa-calendar-alt"></i> Activités</a></li>
            <li><a href="gallery.php"><i class="fas fa-camera"></i> Galerie</a></li>


                        <li><a href="/dar_chabab/membre/show.php"><i class="fas fa-door-open"></i> Réservation </a></li>


            <li><a href="/dar_chabab/login.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
            <li><a href="/dar_chabab/register.php">Register</a></li>

        </ul>
    </nav>
</header>
<style>
     header {
            background-color: #0073aa;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            cursor: default;
        }
        /* Navigation */
        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            padding: 6px 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover,
        nav ul li a.active {
            background-color: #005177;
        }
</style>