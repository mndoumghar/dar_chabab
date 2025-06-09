<?php
include("includes/db.php");

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // التأكد واش البريد الإلكتروني مسجل من قبل
    $check = $conn->prepare("SELECT id FROM membres WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "البريد الإلكتروني مسجل من قبل.";
    } else {
        // التسجيل
        $stmt = $conn->prepare("INSERT INTO membres (nom, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $email, $password);
        if ($stmt->execute()) {
            $success = "تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول.";
        } else {
            $error = "حدث خطأ أثناء التسجيل.";
        }
    }
}
?>

<?php include("includes/header.php"); ?>

<h2 style="text-align:center;">تسجيل عضوية جديدة</h2>

<div style="max-width: 400px; margin: auto;">
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label>الاسم الكامل:</label><br>
        <input type="text" name="nom" required><br><br>

        <label>البريد الإلكتروني:</label><br>
        <input type="email" name="email" required><br><br>

        <label>كلمة المرور:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">تسجيل</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>
