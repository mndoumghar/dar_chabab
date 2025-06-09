<?php
session_start();
if (!isset($_SESSION["membre_id"])) {
    header("Location: ../login.php");
    exit;
}

include("../includes/db.php");

$success = "";
$error = "";

// جلب قائمة القاعات
$salles_result = $conn->query("SELECT id, nom, capacite FROM salles");

// معالجة نموذج الحجز
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membre_id = $_SESSION["membre_id"];
    $salle_id = intval($_POST["salle_id"]);
    $date_reservation = $_POST["date_reservation"];
    $heure_debut = $_POST["heure_debut"];
    $heure_fin = $_POST["heure_fin"];

    // التحقق من صحة الوقت (اختياري - ممكن تزيد تحقق من تعارض الحجز)

    $stmt = $conn->prepare("INSERT INTO reservations (membre_id, salle_id, date_reservation, heure_debut, heure_fin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $membre_id, $salle_id, $date_reservation, $heure_debut, $heure_fin);

    if ($stmt->execute()) {
        $success = "تم حجز القاعة بنجاح.";
    } else {
        $error = "حدث خطأ أثناء الحجز.";
    }
}
?>

<?php include("../includes/header.php"); ?>

<h2 style="text-align:center;">حجز قاعة</h2>

<div style="max-width: 500px; margin: auto;">
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label>اختر القاعة:</label><br>
        <select name="salle_id" required>
            <option value="">-- اختر قاعة --</option>
            <?php
            while ($row = $salles_result->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . " (السعة: " . $row["capacite"] . ")</option>";
            }
            ?>
        </select><br><br>

        <label>تاريخ الحجز:</label><br>
        <input type="date" name="date_reservation" required><br><br>

        <label>وقت بداية الحجز:</label><br>
        <input type="time" name="heure_debut" required><br><br>

        <label>وقت نهاية الحجز:</label><br>
        <input type="time" name="heure_fin" required><br><br>

        <button type="submit">حجز</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
