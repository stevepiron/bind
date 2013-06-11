<?php
	$__TITLE_PAGE__ = 'Bind';
	$__DESC_PAGE__ = '';
	$section = 'home';
	$level = '0';
	
	/*
	 *  Gather all the requests
	 */
	
	try {
		$sql = "SELECT
					r.id AS request_id,
					r.title,
					r.priority,
					r.state,
					r.date,
					r.message,
					r.fk_author,
					u.id AS user_id,
					u.firstname,
					u.picture_url,
					u.useful_answers,
					u.year,
					(SELECT COUNT(*) FROM answers a WHERE a.fk_request = r.id) AS nb_answers,
					c.id AS category_id,
					c.category
				FROM requests r
				LEFT JOIN users u 
				ON r.fk_author = u.id
				LEFT JOIN categories c
				ON r.fk_category = c.id
				ORDER BY r.priority DESC, r.state ASC, r.id DESC"; // Urgent first, then unsolved, then solved. All this by date.
		$res = $db -> query($sql);
	}
	catch(exception $e) {
		'Erreur lors de la récolte des questions : '.$e -> getMessage();
	}
	$requests = $res -> fetchAll(PDO::FETCH_ASSOC); // The array
	$requestsCount = count($requests); // Count how many entries were found
	
	/*
	 *  Display the requests
	 */
	
	// Development purposes
/*
	echo '<div class="devbox"><pre>Résultat de la requête (tableau des questions) :<br>';
		print_r($requests);
	echo '</pre></div><!-- /.devbox -->';
*/
	
	if($requestsCount > 0) {
		$requestsList = listAllRequests($requests, $id); // Echo this ($requestsList) in the html at the right place
	}
	
	
?>

<div class="content">
	<div class="container">
		
		<header role="page-header">
			<div>
				<h1>Questions</h1>
				<div class="headerActions">
					<div class="newFeature">
						<button id="search" class="btn btn-blue feature">Rechercher</button>
						<div class="tip">
							<div class="tipBox">
								<div class="tipArrow"></div>
								<button class="dismiss" id="dismissTipSearch">Fermer</button>
								<p><strong>Nouveau&nbsp;!</strong> Tu peux désormais rechercher parmi l’archive de toutes les questions</p>
							</div><!-- /.tipBox -->
						</div><!-- /.tip -->
					</div><!-- /.newFeature -->
					<?php if($_SESSION && $id != 0): ?>
					<a class="askForHelp btn btn-primary" href="index.php?page=nouvelle-question">Demander de l'aide</a>
					<?php endif ?>
				</div><!-- actions -->
			</div>
		</header>
		
		<?php echo $requestsList; ?>
	</div><!-- /.container -->
</div><!-- /.content -->