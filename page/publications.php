<?php

require "C:/xampp/htdocs/proj/db.php";

$pubs = $conn->query("
SELECT p.titre, p.date_publication, pr.username
FROM publication p
JOIN profil pr ON p.id_profil = pr.id_profil
ORDER BY p.date_publication DESC
");
?>

<h2 class="text-2xl font-bold mb-4">Publications</h2>

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-200">
<tr>
<th class="p-2">Titre</th>
<th>Auteur</th>
<th>Date</th>
</tr>
</thead>
<tbody>
<?php while($p = $pubs->fetch_assoc()): ?>
<tr class="border-b">
<td class="p-2"><?= $p['titre'] ?></td>
<td><?= $p['username'] ?></td>
<td><?= $p['date_publication'] ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
