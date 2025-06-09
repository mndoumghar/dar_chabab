<?php include("includes/header.php"); ?>
<?php include("includes/db.php"); ?>

<h1 style="text-align:center;">مرحبًا بكم في موقع دار الشباب</h1>

<section style="text-align:center;">
    <p>اكتشف الأنشطة، احجز القاعات، وكن جزءاً من مجتمعنا!</p>

    <div>
        <h2>🗓 الأنشطة القادمة</h2>
        <?php
        $sql = "SELECT titre, description, date_activite FROM activites ORDER BY date_activite DESC LIMIT 3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["titre"] . "</strong> - " . $row["description"] . " (" . $row["date_activite"] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>لا توجد أنشطة حالياً.</p>";
        }
        ?>
    </div>

    <div>
        <h2>📷 معرض الصور</h2>
        <img src="assets/images/logo.png" alt="صورة نشاط" width="200">
    </div>
</section>

<?php include("includes/footer.php"); ?>
