<?php
require "C:/xampp/htdocs/proj/db.php";


$totalProfils = $conn->query("SELECT COUNT(*) c FROM profil")->fetch_assoc()['c'];
$totalPublications = $conn->query("SELECT COUNT(*) c FROM publication")->fetch_assoc()['c'];
$totalCommentaires = $conn->query("SELECT COUNT(*) c FROM commentaire")->fetch_assoc()['c'];
$totalLikes = $conn->query("SELECT COUNT(*) c FROM likes")->fetch_assoc()['c'];
$totalAmities = $conn->query("SELECT COUNT(*) c FROM amitié")->fetch_assoc()['c'];


$depRes = $conn->query("
SELECT d.nom_departement, COUNT(p.id_profil) total
FROM departement d
LEFT JOIN profil p ON d.id_departement = p.id_departement
GROUP BY d.id_departement
");
$depLabels = [];
$depData = [];
while ($d = $depRes->fetch_assoc()) {
    $depLabels[] = $d['nom_departement'];
    $depData[] = $d['total'];
}


$actRes = $conn->query("
SELECT DATE(date_publication) jour, COUNT(*) total
FROM publication
GROUP BY jour
ORDER BY jour
");
$actLabels = [];
$actData = [];
while ($a = $actRes->fetch_assoc()) {
    $actLabels[] = $a['jour'];
    $actData[] = $a['total'];
}


$topProfils = $conn->query("
SELECT pr.username,
       COUNT(DISTINCT pub.id_publication) AS pubs,
       COUNT(DISTINCT c.id_commentaire) AS comms,
       COUNT(DISTINCT l.id_publication) AS likes
FROM profil pr
LEFT JOIN publication pub ON pr.id_profil = pub.id_profil
LEFT JOIN commentaire c ON pr.id_profil = c.id_profil
LEFT JOIN likes l ON pr.id_profil = l.id_profil
GROUP BY pr.id_profil
ORDER BY 
    COUNT(DISTINCT pub.id_publication) +
    COUNT(DISTINCT c.id_commentaire) +
    COUNT(DISTINCT l.id_publication) DESC
LIMIT 5
");
?>

<h1 class="text-3xl font-bold mb-6">Dashboard</h1>


<div class="grid grid-cols-5 gap-4 mb-8">
<?php
$cards = [
    ["Profils", $totalProfils],
    ["Publications", $totalPublications],
    ["Commentaires", $totalCommentaires],
    ["Likes", $totalLikes],
    ["Amitiés", $totalAmities]
];
foreach ($cards as $c):
?>
<div class="bg-white rounded shadow p-4 text-center">
    <p class="text-gray-500"><?= $c[0] ?></p>
    <p class="text-3xl font-bold"><?= $c[1] ?></p>
</div>
<?php endforeach; ?>
</div>


<div class="grid grid-cols-2 gap-8 mb-8">

<div class="bg-white p-6 rounded shadow">
<h2 class="font-bold mb-4">Profils par département</h2>
<canvas id="deptChart"></canvas>
</div>

<div class="bg-white p-6 rounded shadow">
<h2 class="font-bold mb-4">Activité des publications</h2>
<canvas id="activityChart"></canvas>
</div>

</div>


<div class="bg-white p-6 rounded shadow">
<h2 class="font-bold mb-4">Top profils les plus actifs</h2>

<table class="w-full">
<thead class="bg-gray-200">
<tr>
<th class="p-2 text-left">Utilisateur</th>
<th>Publications</th>
<th>Commentaires</th>
<th>Likes</th>
</tr>
</thead>
<tbody>
<?php while($t = $topProfils->fetch_assoc()): ?>
<tr class="border-b">
<td class="p-2"><?= $t['username'] ?></td>
<td><?= $t['pubs'] ?></td>
<td><?= $t['comms'] ?></td>
<td><?= $t['likes'] ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>


<script>
new Chart(document.getElementById('deptChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($depLabels) ?>,
        datasets: [{
            data: <?= json_encode($depData) ?>,
            backgroundColor: [
                '#2563eb','#16a34a','#dc2626','#9333ea','#f59e0b'
            ]
        }]
    }
});

new Chart(document.getElementById('activityChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($actLabels) ?>,
        datasets: [{
            label: 'Publications',
            data: <?= json_encode($actData) ?>,
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,0.1)',
            fill: true,
            tension: 0.4
        }]
    }
});
</script>
