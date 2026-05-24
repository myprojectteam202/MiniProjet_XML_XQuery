<?php
$xml = simplexml_load_file("../club.xml");

$page = $_GET['page'] ?? 'concours';

function getLibelleCategorie($xml, $catId)
{
    foreach ($xml->categories->categorie as $cat)
    {
        if ((string)$cat['id'] == (string)$catId)
        {
            return (string)$cat['libelle'];
        }
    }

    return "";
}

function getNomMembre($xml, $membreId)
{
    foreach ($xml->membres->membre as $m)
    {
        if ((string)$m['id'] == (string)$membreId)
        {
            return (string)$m->prenom . " " . (string)$m->nom;
        }
    }

    return "";
}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<title>Club InfoTech</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<header>

<h1>Club InfoTech</h1>

<nav>

<a href="?page=concours">Concours</a>

<a href="?page=resultats">Résultats</a>

<a href="?page=requetes">Requêtes</a>

</nav>

</header>

<main>

<?php if($page == 'concours'): ?>

<section>

<h2>Liste des concours</h2>

<table border="1" cellpadding="10">

<tr>

<th>ID</th>
<th>Titre</th>
<th>Date</th>
<th>Catégorie</th>
<th>Coefficient</th>

</tr>

<?php

foreach($xml->concours->concours as $c)
{
?>

<tr>

<td><?= $c['id'] ?></td>

<td><?= $c->titre ?></td>

<td><?= $c['date'] ?></td>

<td><?= getLibelleCategorie($xml, $c['categorieRef']) ?></td>

<td><?= $c['coefficient'] ?></td>

</tr>

<?php
}
?>

</table>

</section>

<?php elseif($page == 'resultats'): ?>

<section>

<h2>Résultats des concours</h2>

<form method="GET">

<input type="hidden" name="page" value="resultats">

<select name="concoursId">

<option value="">Choisir un concours</option>

<?php
foreach($xml->concours->concours as $c)
{
?>

<option value="<?= $c['id'] ?>">

<?= $c->titre ?>

</option>

<?php
}
?>

</select>

<button type="submit">Afficher</button>

</form>

<?php

if(isset($_GET['concoursId']))
{
    $id = $_GET['concoursId'];

    foreach($xml->concours->concours as $c)
    {
        if((string)$c['id'] == $id)
        {
?>

<h3><?= $c->titre ?></h3>

<table border="1" cellpadding="10">

<tr>

<th>Participant</th>
<th>Complexité</th>
<th>Temps</th>
<th>Score</th>

</tr>

<?php

foreach($c->participants->participant as $p)
{
    $score =
    (
        ((int)$p->complexite)
        +
        ((int)$p->tempsExecution)
    )
    *
    ((float)$c['coefficient']);

?>

<tr>

<td><?= getNomMembre($xml, $p['membreRef']) ?></td>

<td><?= $p->complexite ?></td>

<td><?= $p->tempsExecution ?></td>

<td><?= $score ?></td>

</tr>

<?php
}
?>

</table>

<?php
        }
    }
}
?>

</section>

<?php elseif($page == 'requetes'): ?>

<section>

<h2>Requêtes XML</h2>

<h3>Liste des membres</h3>

<table border="1" cellpadding="10">

<tr>

<th>ID</th>
<th>Nom</th>
<th>Email</th>

</tr>

<?php

foreach($xml->membres->membre as $m)
{
?>

<tr>

<td><?= $m['id'] ?></td>

<td><?= $m->prenom ?> <?= $m->nom ?></td>

<td><?= $m->email ?></td>

</tr>

<?php
}
?>

</table>

</section>

<?php endif; ?>

</main>

<footer>

<p>Mini Projet XML/XQuery - L3 ISIL</p>

</footer>

</body>

</html>