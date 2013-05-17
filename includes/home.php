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
		$sql = "SELECT requests.id, requests.title, requests.category, requests.priority, requests.state, requests.date, requests.message, requests.fk_author, users.id, users.firstname, users.picture_url, users.useful_answers
				FROM requests
				LEFT JOIN users
				ON requests.fk_author = users.id
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
/*
	echo '<div class="devbox"><pre>Résultat de la requête (tableau des questions) :<br>';
		print_r($requests);
	echo '</pre></div><!-- /.devbox -->';
*/
	
	if($requestsCount > 0) {
		$requestsList = listAllRequests($requests); // Echo this ($requestsList) in the html at the right place
	}
	
	
?>

<div class="content">
	<div class="container">
		
		<h1><a href="index.php">Lycée Emile Jacqmain</a></h1>
		
		<?php echo $requestsList; ?>
		
		<ol class="requests">
			<li class="request solved">
				<header>
					<h2 class="pp_loggedIn"><a href="index.php?page=demande-resolue#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
					<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-resolue">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				</header>
				
				<aside>
					<ul>
						<li class="author"><img src="media/img/user/user-female-1@2x.jpg" alt="" width="48" height="48"> Stéphanie</li>
						<li class="bestAnswersCount" title="37 réponses utiles">37</li>
						<li class="publishedDate">Il y a 2 jours</li>
					</ul>
				</aside>
				
				<article>
					<p>Je n’arrive pas à comprendre la nomenclature malgré les exercices de révision que la prof m’a donnés. J’ai un gros test le 28 avril ! Quelqu’un pour m’aider ?</p>
				
    				<footer>
    					<p><a class="answers" href="index.php?page=demande-resolue#interactions_and_loggedIn">4 réponses</a></p>
    				</footer>
				</article>
			</li><!-- /.request -->
			<li class="request unanswered">
				<header>
					<h2 class="pp_loggedIn"><a href="index.php?page=demande-non-resolue#loggedIn">Exercices sur les logarithmes (math fortes)</a> <a class="label" href="#">Mathématiques</a></h2>
					<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-non-resolue">Exercices sur les logarithmes (math fortes)</a> <a class="label" href="#">Mathématiques</a></h2>
				</header>
				
				<aside>
					<ul>
						<li class="author"><img src="media/img/user/user-male-2@2x.png" alt="" width="48" height="48"> Maxime</li>
						<li class="bestAnswersCount" title="122 réponses utiles">122</li>
						<li class="publishedDate">Il y a 2 jours</li>
					</ul>
				</aside>
				
				<article>
					<p>J'ai raté le dernier cours (M. Danterre), je me suis mis en ordre au niveau de la théorie que j'ai déjà relue pas mal de fois mais j'ai vraiment du mal à les appliquer aux exercices... Quelqu'un qui a compris pourrait m'expliquer ? Merci !</p>
				
    				<footer>
    					<a class="btn pp_loggedIn" href="index.php?page=demande-non-resolue#commentForm">Répondre</a>
    					<a class="btn btn-link watchToggle pp_loggedIn" href="#">Surveiller cette question</a>
    					<p><a class="answers" href="index.php?page=demande-non-resolue#interactions_and_loggedIn">0 réponse</a> • <a class="interest" href="">1 intéressé</a></p>
    					<div class="interestedUsersFaces">
							<img src="../media/img/user/user-male-3@2x.jpg" alt="" width="48" height="48">
						</div><!-- /.interestedUsersFaces -->
    				</footer>
				</article>
			</li><!-- /.request -->
			<li class="request urgent">
				<header>
					<h2 class="pp_loggedIn"><a href="index.php?page=demande-urgente#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
					<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-urgente">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				</header>
				
				<aside>
					<ul>
						<li class="author"><img src="media/img/user/user-female-1@2x.jpg" alt="" width="48" height="48"> Stéphanie</li>
						<li class="bestAnswersCount" title="37 réponses utiles">37</li>
						<li class="publishedDate">Il y a 2 jours</li>
					</ul>
				</aside>
				
				<article>
					<p>Je n’arrive pas à comprendre la nomenclature malgré les exercices de révision que la prof m’a donnés. J’ai un gros test le 28 avril ! Quelqu’un pour m’aider ?</p>
				
    				<footer>
    					<a class="btn pp_loggedIn" href="index.php?page=demande-urgente#commentForm_and_loggedIn">Répondre</a>
    					<a class="btn btn-link watchToggle pp_loggedIn" href="#">Surveiller cette question</a>
    					<p><a class="answers" href="index.php?page=demande-urgente#interactions_and_loggedIn">2 réponses</a> • <a class="interest" href="">3 intéressés</a></p>
    					<div class="interestedUsersFaces">
							<img src="../media/img/user/user-female-2@2x.jpg" alt="" width="48" height="48">
							<img src="../media/img/user/user-female-4@2x.jpg" alt="" width="48" height="48">
							<img src="../media/img/user/user-male-3@2x.jpg" alt="" width="48" height="48">
						</div><!-- /.interestedUsersFaces -->
    				</footer>
				</article>
			</li><!-- /.request -->
			<li class="request unanswered">
				<header>
					<h2 class="pp_loggedIn"><a href="index.php?page=demande-non-resolue#loggedIn">Exercices sur les logarithmes (math fortes)</a> <a class="label" href="#">Mathématiques</a></h2>
					<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-non-resolue">Exercices sur les logarithmes (math fortes)</a> <a class="label" href="#">Mathématiques</a></h2>
				</header>
				
				<aside>
					<ul>
						<li class="author"><img src="media/img/user/avatar@2x.png" alt="" width="48" height="48"> Moi</li>
						<li class="bestAnswersCount" title="6 réponses utiles">6</li>
						<li class="publishedDate">Il y a 3 jours</li>
					</ul>
				</aside>
				
				<article>
					<p>J'ai raté le dernier cours (M. Danterre), je me suis mise en ordre au niveau de la théorie que j'ai déjà relue pas mal de fois mais j'ai vraiment du mal à les appliquer aux exercices... Quelqu'un qui a compris pourrait m'expliquer (de préférence un mercredi après-midi) ? Merci !</p>
				
    				<footer>
    					<a class="btn pp_loggedIn" href="index.php?page=demande-non-resolue#commentForm">Répondre</a>
    					<a class="btn btn-link watchToggle watching pp_loggedIn" href="#">Surveiller cette question</a>
    					<p><a class="answers" href="index.php?page=demande-non-resolue#interactions_and_loggedIn">0 réponse</a> • <a class="interest interest0" href="">0 intéressé</a></p>
    				</footer>
				</article>
			</li><!-- /.request -->
		</ol>
		
		<p id="showMore"><a href="#">Voir plus d'annonces</a></p>
	</div><!-- /.container -->
</div><!-- /.content -->