<?php
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
 <script src="https://cdn.tailwindcss.com"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<body class="bg-gray-100">

<div class="flex">
<?php include "C:/xampp/htdocs/proj/sidebar.php"; ?>

<main class="flex-1 p-8">
<?php
if (file_exists("page/$page.php")) {
    include "page/$page.php";
} else {
    echo "<h1 class='text-xl'>Page introuvable</h1>";
}
?>
</main>
</div>

</body>
</html>
