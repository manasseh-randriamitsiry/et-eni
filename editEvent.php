<?php

require_once('bdd.php');
if (isset($_POST['delete']) && isset($_POST['id'])){
	$id = $_POST['id'];
	
	$sql = "DELETE FROM events WHERE id = $id";
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])){
	$id = $_POST['id'];
	$title = $_POST['title'];
	$salle = $_POST['salle'];
	$enseignant = $_POST['enseignant'];
	$color = $_POST['color'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	if (strtotime($start) >= strtotime($end)) {
		header('Location: index.php?error=Date fin doit etre apres date debut');
		exit(); // Stop further execution
	}
	
	$sql = "UPDATE events SET  title = '$title', color = '$color',salle = '$salle', enseignant = '$enseignant', start = '$start', end = '$end' WHERE id = $id ";

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
header('Location: index.php');

	
?>
