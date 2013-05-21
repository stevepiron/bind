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
								r.fk_category,
								r.priority,
								r.state,
								r.date,
								r.message,
								r.fk_author,
								u.id AS author_id,
								u.firstname,
								u.picture_url,
								u.useful_answers,
								(SELECT COUNT(*) FROM answers a WHERE a.fk_request = r.id) AS nb_answers,
								c.id AS category_id,
								c.category,
								c.year,
								c.group
							FROM requests r
							LEFT JOIN users u 
							ON r.fk_author = u.id
							LEFT JOIN categories c
							ON r.fk_category = c.id
							WHERE r.id = '".$requestId."'
							ORDER BY r.id DESC";
					$res = $db -> query($sql);
				}
				catch(exception $e) {
					'Erreur lors de la récolte de la question : '.$e -> getMessage();
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
							WHERE r.id = '".$requestId."'
							ORDER BY a.date ASC";
					$res = $db -> query($sql);
					
				}
				catch(exception $e) {
					'Erreur lors de la récolte des réponses : '.$e -> getMessage();
				}
				$answers = $res -> fetchAll(PDO::FETCH_ASSOC); // The array
				$answersCount = count($answers); // Count how many entries were found
				
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
				if($answersCount > 0) {
					// If there's at leat one answer
					$answersThread = answersThread($answers, $id);
				}
		}
	}
	else {
		// Invalid approach: no &id= in the url
		setError(ERR_NODATAINURL);
	}
	
	if($_POST['reply']) {
		if(isset($_POST['reply'])) {
			
			$message = trim(strip_tags($_POST['message']));
			$now = date('Y-m-d H:i:s');
			
			// Define error variables as NULL
			// so that they're not rendered
			// if the error is not targeted
			$errors = 0;
			$error_emptyMessage = NULL;
			
			/*
			 *  Error handling
			 */
			 
			// Message verification
			if(empty($message)) {
				$errors++;
				$error_emptyMessage = 'Ta réponse est vide ! :(';
			}
			
			/*
			 *  No error found
			 *  Insert into the database
			 */
			 
			if($errors == 0) {
				try {
					$sql = "INSERT INTO answers (fk_author, message, fk_request, date)
									VALUES ('$id', '$message', '$requestId', '$now')";
					$db -> exec($sql);
				}
				catch(exception $e) {
					'Erreur lors de l\'envoi de ta réponse : '.$e -> getMessage();
				}
				$feedback = '<p class="notice success">Super, merci beaucoup pour ta réponse ! :)</p>';
			}
			// Errors found
			else {
				$feedback = '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyMessage.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
			}
		}
	}
	
	if($request) {
		$__TITLE_PAGE__ = $request[0]['title'].' ('.$request[0]['category'].') • Bind';
	}
?>

<div class="content">
	<div class="container">
		<h1>Salle de remédiation</h1>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
		
			echo $theRequest;
			echo $answersThread;
		?>
		<section class="actions">
			<?php	
				if($request[0]['state'] == 1) {
					// Request in solved
			?>
				<a class="btn" href="index.php">Retour aux questions</a>
			<?php
				}
				else {
					// Request is not solved yet
					if($id != 0) {
						// User is logged in
			?>
			<form id="commentForm" class="clearfix" action="" method="post">
				<img class="userAvatar rounded" src="<?php echo $dig; echo $_SESSION['picture_url']; ?>" alt="Ma photo (<?php echo $_SESSION['firstname']; ?>)" width="48" height="48">
				<div>
					<textarea name="message" id="comment"></textarea>
					<?php if($request[0]['priority'] == 0): ?>
					<input type="submit" name="reply" class="btn btn-green" value="Envoyer ma réponse">
					<?php else: ?>
					<input type="submit" name="reply" class="btn btn-red" value="Envoyer ma réponse">
					<?php endif ?>
					<a class="btn" href="index.php">Retour aux questions</a>
				</div>
			</form><!-- /#commentForm -->
			<?php
					}
					else {
						// User is not logged in
			?>
					<a class="btn" href="index.php">Retour aux questions</a>
		</section><!-- /.actions -->
			<?php
					}
				}
			?>
	</div><!-- /.container -->
</div><!-- /.content -->