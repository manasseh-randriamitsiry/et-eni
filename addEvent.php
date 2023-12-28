<?php

// Connexion à la base de données
require_once('bdd.php');
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])&& isset($_POST['enseignant']) && isset($_POST['salle'])){
	
	$title = $_POST['title'];
	$salle = $_POST['salle'];
	$enseignant = $_POST['enseignant'];
	$start = $_POST['start'];

	$end = $_POST['end'];
	$color = $_POST['color'];
	if (strtotime($start) >= strtotime($end)) {
		header('Location: index.php?error=Date fin doit etre apres date debut');
		exit(); // Stop further execution
	}

	$sql = "INSERT INTO events(title, start, end, color, enseignant, salle ) values ('$title', '$start', '$end', '$color', '$enseignant', '$salle')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	
	echo $sql;
	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
