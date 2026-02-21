<?php
require "C:/xampp/htdocs/proj/db.php";

$popular = $conn->query("
SELECT p.titre, COUNT(l.id_publication) likes
FROM publication p
LEFT JOIN likes l ON p.id_publication = l.id_publication
GROUP BY p.id_publication
ORDER BY likes DESC
");
?>

<h2 class="text-2xl font-bold mb-4">Publications les plus likées</h2>

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-200">
<tr>
<th class="p-2">Titre</th>
<th>Likes</th>
</tr>
</thead>
<tbody>
<?php while($p = $popular->fetch_assoc()): ?>
<tr class="border-b">
<td class="p-2"><?= $p['titre'] ?></td>
<td><?= $p['likes'] ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
