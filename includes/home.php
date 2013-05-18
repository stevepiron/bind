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
					r.id AS request_id,
					r.title,
					r.category,
					r.priority,
					r.state,
					r.date,
					r.message,
					r.fk_author,
					u.id AS user_id,
					u.firstname,
					u.picture_url,
					u.useful_answers,
					(SELECT COUNT(*) FROM answers a WHERE a.fk_request = r.id) as nb_answers
				FROM requests r
				LEFT JOIN users u 
				ON r.fk_author = u.id
				ORDER BY r.id DESC";
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