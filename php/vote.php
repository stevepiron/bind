<?php

	$answerId = $_GET['id'];
	$request = $_GET['r'];
	
	// Includes
	require 'functions.php';
	require 'constants.php';
	require 'database-connection.php';
	
	$sql1 = "UPDATE answers
			 SET value = '0'
			 WHERE fk_request = '$request'";
	
	$sql2 = "UPDATE answers
			 SET value = '1'
			 WHERE fk_request = '$request'
			 AND id = '$answerId'";
	
	try {
		$db -> exec($sql1);
		$db -> exec($sql2);
	}
	catch(exception $e) {
		'Erreur lors du vote : '.$e -> getMessage();
	}

?>