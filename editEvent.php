<?php

require_once('bdd.php');

if (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id']) && isset($_POST['niveau']) && isset($_POST['enseignant']) && isset($_POST['salle'])) {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$salle = $_POST['salle'];
	$enseignant = $_POST['enseignant'];
	$niveau = $_POST['niveau'];
	$color = $_POST['color'];
	$start = $_POST['start'];
	$end = $_POST['end'];

	if (strtotime($start) >= strtotime($end)) {
		header('Location: index.php?message=Date fin doit etre apres date debut');
		exit(); // Stop further execution
	}

	// Vérification de la disponibilité de la salle
	$availabilityQuery = $bdd->prepare("SELECT * FROM events WHERE salle = :salle AND id <> :id AND ((start >= :start AND start < :end) OR (end > :start AND end <= :end) OR (start <= :start AND end >= :end))");
	$availabilityQuery->bindParam(':salle', $salle, PDO::PARAM_STR);
	$availabilityQuery->bindParam(':id', $id, PDO::PARAM_INT);
	$availabilityQuery->bindParam(':start', $start, PDO::PARAM_STR);
	$availabilityQuery->bindParam(':end', $end, PDO::PARAM_STR);
	$availabilityQuery->execute();

	$availabilityResult = $availabilityQuery->fetch(PDO::FETCH_ASSOC);

	if ($availabilityResult) {
		$occupiedStart = $availabilityResult['start'];
		$occupiedEnd = $availabilityResult['end'];
		$formattedMessage = "La salle est déjà occupée du $occupiedStart au $occupiedEnd.";
		header("Location: index.php?message=$formattedMessage");
		exit(); // Stop further execution
	}

	// Mise à jour de l'événement si la salle est disponible
	$sql = "UPDATE events SET title = '$title', color = '$color', salle = '$salle', enseignant = '$enseignant', niveau = '$niveau', start = '$start', end = '$end' WHERE id = $id";

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

	header('Location: index.php?message=modification avec success');
}

if (isset($_POST['delete'])) {
	$id = $_POST['id'];
	$sql = "DELETE FROM events WHERE id = $id";
	$query = $bdd->prepare($sql);
	if ($query == false) {
		print_r($bdd->errorInfo());
		header('Location: index.php?message=Erreur deletion');
	}
	$res = $query->execute();
	if ($res == false) {
		print_r($query->errorInfo());
		die('Erreur execute');
	}
	header('Location: index.php?message=deletion avec success');
}
?>
