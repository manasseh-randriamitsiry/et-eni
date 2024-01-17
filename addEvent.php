<?php

// Connexion à la base de données
require_once('bdd.php');

if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color']) && isset($_POST['enseignant']) && isset($_POST['salle'])) {

	$title = $_POST['title'];
	$salle = $_POST['salle'];
	$enseignant = $_POST['enseignant'];
	$niveau = $_POST['niveau'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	if (strtotime($start) >= strtotime($end)) {
		header('Location: index.php?message=Date fin doit etre apres date debut');
		exit(); // Stop further execution
	}

	// Vérification de la disponibilité de la salle
	$availabilityQuery = $bdd->prepare("SELECT * FROM events WHERE salle = :salle AND ((start >= :start AND start < :end) OR (end > :start AND end <= :end) OR (start <= :start AND end >= :end))");
	$availabilityQuery->bindParam(':salle', $salle, PDO::PARAM_STR);
	$availabilityQuery->bindParam(':start', $start, PDO::PARAM_STR);
	$availabilityQuery->bindParam(':end', $end, PDO::PARAM_STR);
	$availabilityQuery->execute();

	$availabilityResult = $availabilityQuery->fetch(PDO::FETCH_ASSOC);

	if ($availabilityResult) {
		header("Location: index.php?message=La salle est déjà occupée pendant $start au $end");
		exit(); // Stop further execution
	}

	// Insertion de l'événement si la salle est disponible
	$sql = "INSERT INTO events(title, start, end, color, enseignant, salle, niveau) values ('$title', '$start', '$end', '$color', '$enseignant', '$salle', '$niveau')";
	$query = $bdd->prepare($sql);

	if ($query == false) {
		print_r($bdd->errorInfo());
		die('Erreur prepare');
	}

	$sth = $query->execute();

	if ($sth == false) {
		print_r($query->errorInfo());
		die('Erreur execute');
	}
}

header('Location: index.php?message=Ajout avec success');
?>
