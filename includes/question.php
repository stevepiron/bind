<?php
	$__TITLE_PAGE__ = 'Nomenclature (chimie) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'question';
	$level = '1';
	
	if($_GET['id']) {
		if(isset($_GET)) {
			// Extract GET data
			$requestId = $_GET['id'];
			
				/*
				 *  Gather the request and its answers
				 */
				
				// The request and its number of answers
				try {
					$sql = "SELECT
								r.id AS request_id,
								r.title,
								r.category,
								r.priority,
								r.state,
								r.date AS request_date,
								r.message AS request_message,
								r.fk_author AS request_author,
								u.id AS request_author_id,
								u.firstname AS request_author_firstname,
								u.picture_url AS request_author_pictureUrl,
								u.useful_answers AS answer_author_usefulAnswers,
								(SELECT COUNT(*) FROM answers a WHERE a.fk_request = r.id) AS nb_answers
							FROM requests r
							LEFT JOIN users u 
							ON r.fk_author = u.id
							WHERE r.id = '".$requestId."'
							ORDER BY r.id DESC";
					$res = $db -> query($sql);
				}
				catch(exception $e) {
					'Erreur lors de la récolte des questions : '.$e -> getMessage();
				}
				$request = $res -> fetchAll(PDO::FETCH_ASSOC); // The array
				$requestCount = count($requests); // Count how many entries were found
				
				// The answers
				try {
					$sql = "SELECT
								a.id AS answer_id,
								a.fk_author AS answer_author,
								a.message AS answer_message,
								a.fk_request,
								a.date AS answer_date,
								a.value,
								u.id AS answer_author_id,
								u.firstname AS answer_author_firstname,
								u.picture_url AS answer_author_pictureUrl,
								u.useful_answers AS answer_author_usefulAnswers,
								r.id AS request_id
							FROM answers a
							LEFT JOIN users u
							ON a.fk_author = u.id
							LEFT JOIN requests r
							ON a.fk_request = r.id
							WHERE r.id = '".$requestId."'";
					$res = $db -> query($sql);
					
				}
				catch(exception $e) {
					'Erreur lors de la récolte des réponses : '.$e -> getMessage();
				}
				$answers = $res -> fetchAll(PDO::FETCH_ASSOC); // The array
				$answersCount = count($requests); // Count how many entries were found
				
				/*
				 *  Display the requests
				 */
				
				// Development purposes
				echo '<div class="devbox"><pre>Résultat de la requête 1 (la question) :<br>';
					print_r($request);
				echo '<br>Résultat de la requête 2 (les réponses) :<br>';
					print_r($answers);
				echo '</pre></div><!-- /.devbox -->';
			
		}
	}
	else {
		// Invalid approach: no &id= in the url
		setError(ERR_NODATAINURL);
	}


?>

<div class="content">
	<div class="container">
		<h1><a href="index.php">Lycée Emile Jacqmain</a></h1>
		
		<section class="request">
			<header>
				<h2 class="pp_loggedIn"><a href="index.php?page=demande-non-resolue#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-non-resolue">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
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
					<p><a class="answers" href="index.php?page=demande-non-resolue#interactions_and_loggedIn">0 réponse</a> • <a class="interest" href="">1 intéressé</a></p>
				</footer>
			</article>
		</section><!-- /.request -->
		
		<section id="interactions">
			<section class="actions">
				<a class="btn pp_loggedIn_and_not_commenting" href="#pp_toggle_commenting">Répondre</a>
				
				<form id="commentForm" class="pp_loggedIn_and_commenting clearfix" action="#" method="post">
					<img class="userAvatar rounded" src="<?php echo $dig; ?>media/img/user/avatar@2x.png" alt="User name" width="48" height="48">
					<textarea name="comment" id="comment"></textarea>
					<input type="submit" class="btn btn-green" value="Envoyer ma réponse">
				</form><!-- /#commentForm -->
			</section><!-- /.actions -->
		</section><!-- /#interactions -->
	</div><!-- /.container -->
</div><!-- /.content -->