<?php
session_start();
// check ila kayn admin
include("../includes/db.php");

$error = $success = "";

//  addd activiter
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $date_activite = $_POST["date_activite"];
// zid photos 
    $image = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../assets/images/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    $stmt = $conn->prepare("INSERT INTO activites (titre, description, date_activite, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titre, $description, $date_activite, $image);
    if ($stmt->execute()) {
        $success = "تم إضافة النشاط بنجاح.";
    } else {
        $error = "حدث خطأ أثناء إضافة النشاط.";
    }
}


if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM activites WHERE id = $id");
    header("Location: activites.php");
    exit;
}

$activites = $conn->query("SELECT * FROM activites ORDER BY date_activite DESC");
?>

<?php include("../includes/header.php"); ?>

<h2>Mangement activiter</h2>

<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

<h3>Add new acteveter</h3>
<form method="POST" enctype="multipart/form-data">
    <label>title actv</label><br>
    <input type="text" name="titre" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>date /// </label><br>
    <input type="date" name="date_activite" required><br><br>

    <label>photo actv</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit" name="ajouter">إضافة</button>
</form>

<hr>

<h3>List actveter ... </h3>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>titre</th>
            <th>desciption</th>
            <th>date</th>
            <th>photo</th>
            <th>delete</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $activites->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["titre"]) ?></td>
            <td><?= htmlspecialchars($row["description"]) ?></td>
            <td><?= $row["date_activite"] ?></td>
            <td>
                <?php if ($row["image"]): ?>
                    <img src="../assets/images/<?= htmlspecialchars($row["image"]) ?>" width="100" alt="صورة النشاط">
                <?php else: ?>
                    لا توجد صورة
                <?php endif; ?>
            </td>
            <td><a href="?delete=<?= $row["id"] ?>" onclick="return confirm('هل تريد حذف هذا النشاط؟');">حذف</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include("../includes/footer.php"); ?>
