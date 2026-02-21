<?php
require "C:/xampp/htdocs/proj/db.php";

$dep = $_GET['dep'] ?? '';

$deps = $conn->query("SELECT * FROM departement");

$sql = "
SELECT p.*, d.nom_departement
FROM profil p
JOIN departement d ON p.id_departement = d.id_departement
";

if ($dep) {
    $sql .= " WHERE p.id_departement = $dep";
}

$profils = $conn->query($sql);
?>

<h2 class="text-2xl font-bold mb-4">Liste des profils</h2>

<form method="get" class="mb-4">
<input type="hidden" name="page" value="profils">
<select name="dep" class="p-2 border rounded">
    <option value="">-- Tous les départements --</option>
    <?php while($d = $deps->fetch_assoc()): ?>
        <option value="<?= $d['id_departement'] ?>" <?= $dep==$d['id_departement']?'selected':'' ?>>
            <?= $d['nom_departement'] ?>
        </option>
    <?php endwhile; ?>
</select>
<button class="bg-blue-600 text-white px-4 py-2 rounded">Filtrer</button>
</form>

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-200">
<tr>
<th class="p-2">Nom</th>
<th>Email</th>
<th>Département</th>
<th>Inscription</th>
</tr>
</thead>
<tbody>
<?php while($p = $profils->fetch_assoc()): ?>
<tr class="border-b">
<td class="p-2"><?= $p['prenom'].' '.$p['nom'] ?></td>
<td><?= $p['email'] ?></td>
<td><?= $p['nom_departement'] ?></td>
<td><?= $p['date_inscription'] ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
