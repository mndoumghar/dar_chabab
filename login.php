<?php
session_start();
include("includes/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, nom, password FROM membres WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nom, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // تسجيل الدخول ناجح
            $_SESSION["membre_id"] = $id;
            $_SESSION["membre_nom"] = $nom;

            header("Location: membre/reserver.php");
            exit;
        } else {
            $error = "كلمة المرور غير صحيحة.";
        }
    } else {
        $error = "البريد الإلكتروني غير موجود.";
    }
}
?>

<?php include("includes/header.php"); ?>

<h2 style="text-align:center;">تسجيل الدخول</h2>

<div style="max-width: 400px; margin: auto;">
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label>البريد الإلكتروني:</label><br>
        <input type="email" name="email" required><br><br>

        <label>كلمة المرور:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">دخول</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>
