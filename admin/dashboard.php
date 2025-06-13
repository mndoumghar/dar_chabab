<?php
session_start();
// مثلاً: if (!isset($_SESSION["admin_logged_in"])) { header("Location: ../login.php"); exit; }
// had dyal admin  
//mli katdkhl b admin admin
//katl3 lik had lpage 
include("../includes/db.php");
?>

<?php include("../includes/header.php"); ?>

<h2 style="text-align:center;">dashboard admin</h2>

<nav style="text-align:center; margin-bottom:20px;">
    <a href="activites.php">إدارة الأنشطة</a> |
    <a href="salles.php">إدارة القاعات</a> |
    <a href="membres.php">قائمة الأعضاء</a> |
    <a href="reservations.php">قائمة الحجوزات</a>
</nav>

<p style="text-align:center;">مرحباً بك في ///   دار الشباب.</p>

<?php include("../includes/footer.php"); ?>
