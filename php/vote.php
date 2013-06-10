<?php

	$answerId = $_GET['id'];
	$request = $_GET['r'];
	
	// Includes
	require 'functions.php';
	require 'constants.php';
	require 'database-connection.php';
	
	
	// Default state for all answers
	$sql1 = "UPDATE answers
			 SET value = '0'
			 WHERE fk_request = '$request'";
	
	// Define the best answer
	$sql2 = "UPDATE answers
			 SET value = '1'
			 WHERE fk_request = '$request'
			 AND id = '$answerId'";
	
	// Set the request as solved
	$sql3 = "UPDATE requests
			 SET state = '1', priority = '0'
			 WHERE id = '$request'";
	
	try {
		$db -> exec($sql1);
		$db -> exec($sql2);
		$db -> exec($sql3);
	}
	catch(exception $e) {
		'Erreur lors du vote : '.$e -> getMessage();
	}

?>