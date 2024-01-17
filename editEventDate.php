<?php

// Connexion à la base de données
require_once('bdd.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];

	// Vérification de la disponibilité de la salle
	$availabilityQuery = $bdd->prepare("SELECT * FROM events WHERE id = :id");
	$availabilityQuery->bindParam(':id', $id, PDO::PARAM_INT);
	$availabilityQuery->execute();

	$eventData = $availabilityQuery->fetch(PDO::FETCH_ASSOC);

	if (!$eventData) {
		// L'événement n'existe pas
		die('Erreur: L\'événement n\'existe pas.');
	}

	$salle = $eventData['salle'];

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
		die($formattedMessage);
	}

	// Mise à jour de l'événement si la salle est disponible
	$sql = "UPDATE events SET start = '$start', end = '$end' WHERE id = $id";

	$query = $bdd->prepare($sql);
	if ($query == false) {
		print_r($bdd->errorInfo());
		die('Erreur prepare');
	}

	$sth = $query->execute();
	if ($sth == false) {
		print_r($query->errorInfo());
		die('Erreur execute');
	} else {
		die('OK');
	}
}
?>
