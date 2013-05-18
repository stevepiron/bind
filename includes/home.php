<?php
	$__TITLE_PAGE__ = 'Bind';
	$__DESC_PAGE__ = '';
	$section = 'home';
	$level = '0';
	
	// session_start();
	
	/*
	 *  Gather all the requests
	 */
	
	try {
		$sql = "SELECT
					requests.id AS request_id,
					requests.title,
					requests.category,
					requests.priority,
					requests.state,
					requests.date,
					requests.message,
					requests.fk_author,
					users.id AS users_id,
					users.firstname,
					users.picture_url,
					users.useful_answers,
					answers.fk_request
				FROM requests
				LEFT JOIN users
				ON requests.fk_author = users.id
				LEFT JOIN answers
				ON requests.id = answers.fk_request
				ORDER BY requests.id DESC";
		$res = $db -> query($sql);
		$requests = $res -> fetchAll(PDO::FETCH_ASSOC); // The array
		$requestsCount = count($requests); // Count how many entries were found
	}
	catch(exception $e) {
		'Erreur lors de la récolte des questions : '.$e -> getMessage();
	}
	
	/*
	 *  Display the requests
	 */
	
	// Development purposes
	echo '<div class="devbox"><pre>Résultat de la requête (tableau des questions) :<br>';
		print_r($requests);
	echo '</pre></div><!-- /.devbox -->';
	
	if($requestsCount > 0) {
		$requestsList = listAllRequests($requests, $id); // Echo this ($requestsList) in the html at the right place
	}
	
	
?>

<div class="content">
	<div class="container">
		
		<h1><a href="index.php">Lycée Emile Jacqmain</a></h1>
		
		<?php echo $requestsList; ?>
		
		<p id="showMore"><a href="#">Voir plus d'annonces</a></p>
	</div><!-- /.container -->
</div><!-- /.content -->