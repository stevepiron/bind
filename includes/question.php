<?php
	$__TITLE_PAGE__ = 'Question • Bind'; // Needs variables from the SQL request
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
								r.date,
								r.message,
								r.fk_author,
								u.id AS author_id,
								u.firstname,
								u.picture_url,
								u.useful_answers,
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
								a.fk_author AS author,
								a.message,
								a.fk_request,
								a.date,
								a.value,
								u.id AS author_id,
								u.firstname,
								u.picture_url,
								u.useful_answers,
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
/*
				echo '<div class="devbox"><pre>Résultat de la requête 1 (la question) :<br>';
					print_r($request);
				echo '<br>Résultat de la requête 2 (les réponses) :<br>';
					print_r($answers);
				echo '</pre></div><!-- /.devbox -->';
*/
				
				$theRequest = singleRequest($request, $id);
				$answersThread = answersThread($answers, $id);
			
		}
	}
	else {
		// Invalid approach: no &id= in the url
		setError(ERR_NODATAINURL);
	}
	
	if($request) {
		$__TITLE_PAGE__ = $request[0]['title'].' ('.$request[0]['category'].') • Bind';
	}
	
?>

<div class="content">
	<div class="container">
		<h1><a href="index.php">Lycée Emile Jacqmain</a></h1>
		
		<?php
			echo $theRequest;
			echo $answersThread;
			
			if($request[0]['state'] == 1) {
				// Request in solved
		?>
				<a class="btn back" href="index.php">Retour aux questions</a>
		<?php
			}
			else {
				// Request is not solved yet
				if($id != 0) {
					// User is logged in
		?>
		
		<section id="interactions">
			<section class="actions">
				<form id="commentForm" class="clearfix" action="#" method="post">
					<img class="userAvatar rounded" src="<?php echo $dig; echo $_SESSION['picture_url']; ?>" alt="Ma photo (<?php echo $_SESSION['firstname']; ?>)" width="48" height="48">
					<textarea name="comment" id="comment"></textarea>
					<input type="submit" class="btn btn-green" value="Envoyer ma réponse">
					<a class="btn" href="#">Retour aux questions</a>
				</form><!-- /#commentForm -->
			</section><!-- /.actions -->
		</section><!-- /#interactions -->
		
		<?php
				}
			}
		?>
	</div><!-- /.container -->
</div><!-- /.content -->