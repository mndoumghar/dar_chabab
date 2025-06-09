<?php
session_start();
// هنا خاصك تضيف تحقق من صلاحية المشرف
// مثلاً: if (!isset($_SESSION["admin_logged_in"])) { header("Location: ../login.php"); exit; }

include("../includes/db.php");
?>

<?php include("../includes/header.php"); ?>

<h2 style="text-align:center;">لوحة تحكم المشرف</h2>

<nav style="text-align:center; margin-bottom:20px;">
    <a href="activites.php">إدارة الأنشطة</a> |
    <a href="salles.php">إدارة القاعات</a> |
    <a href="membres.php">قائمة الأعضاء</a> |
    <a href="reservations.php">قائمة الحجوزات</a>
</nav>

<p style="text-align:center;">مرحباً بك في لوحة تحكم دار الشباب.</p>

<?php include("../includes/footer.php"); ?>
