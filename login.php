<?php
session_start();
include("includes/db.php");

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $motdepasse = $_POST["motdepasse"];

    $stmt = $conn->prepare("SELECT id, nom, password FROM membres WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nom, $hashed_password);
        $stmt->fetch();

        if (password_verify($motdepasse, $hashed_password)) {
            $_SESSION["membre_id"] = $id;
            $_SESSION["membre_nom"] = $nom;
            header("Location: membre/reserver.php");
            exit;
        } else {
            $erreur = "Mot de passe incorrect";
        }
    } else {
        $erreur = "Email ou mot de passe invalide";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Maison de la Jeunesse</title>
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
            max-width: 400px;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 115, 170, 0.2);
        }
        
        .login-form h1 {
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
        
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-group input:focus {
            border-color: var(--bleu-principal);
            box-shadow: 0 0 0 3px rgba(0, 115, 170, 0.2);
            outline: none;
        }
        
        input[type="submit"] {
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
        
        input[type="submit"]:hover {
            background: var(--bleu-fonce);
        }
        
        input[type="submit"]::after {
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
        
        input[type="submit"]:focus:not(:active)::after {
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
        
        .extra-options {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
        }
        
        .extra-options a {
            color: var(--bleu-principal);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .extra-options a:hover {
            color: var(--bleu-fonce);
            text-decoration: underline;
        }
        
        .extra-options span {
            margin: 0 10px;
            color: #aaa;
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
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="main">
    <div class="container">
        <form method="post" class="login-form">
            <h1><i class="fas fa-sign-in-alt"></i> Connexion Membre</h1>
            
            <?php if (!empty($erreur)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $erreur; ?>
                </div>
            <?php endif; ?>
            
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="Votre email" required>
            </div>
            
            <div class="input-group">
                <label for="motdepasse"><i class="fas fa-lock"></i> Mot de passe</label>
                <input type="password" id="motdepasse" name="motdepasse" placeholder="Votre mot de passe" required>
            </div>
            
            <input type="submit" value="Se connecter">
            
            <div class="extra-options">
                <a href="forget.php"><i class="fas fa-key"></i> Mot de passe oublié?</a>
                <span>ou</span>
                <a href="register.php"><i class="fas fa-user-plus"></i> S'inscrire</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>