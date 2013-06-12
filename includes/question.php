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
								u.year,
								(SELECT COUNT(*) FROM answers a WHERE a.fk_request = r.id) AS nb_answers,
								c.id AS category_id,
								c.category
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
					$answersThread = answersThread($answers, $request, $id);
				}
		}
	}
	else {
		// Invalid approach: no &id= in the url
		setError(ERR_NODATAINURL);
	}
	
	if($_POST['reply']) {
		if(isset($_POST['reply'])) {
			
			$message = $_POST['message'];
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
				$feedback = '<div class="noticeContainer"><p class="notice success">Super, merci beaucoup pour ta réponse ! :)</p></div><!-- /.noticeContainer -->';
				$message = '';
			}
			// Errors found
			else {
				$feedback  = '<div class="noticeContainer">';
				$feedback .= '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyMessage.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
				$feedback .= '</div><!-- /.noticeContainer -->';
			}
		}
	}
	
	if($request) {
		$__TITLE_PAGE__ = $request[0]['title'].' ('.htmlentities($request[0]['category']).') • Bind';
		// htmlentities needed for the category as
		// they have been entered from the database
	}
?>

<div class="content">
	<div class="container">
		<header role="page-header">
			<div>
				<h1>Question</h1>
				<div class="headerActions">
					<button id="search" class="btn btn-blue">Rechercher</button>
					<?php if($_SESSION && $id != 0): ?>
					<a class="askForHelp btn btn-primary" href="index.php?page=nouvelle-question">Demander de l'aide</a>
					<?php endif ?>
				</div><!-- actions -->
			</div>
		</header>
		
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
					<div id="wysihtml5-toolbar" style="display: none;">
						<a data-wysihtml5-command="bold">Gras</a>
						
						<!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
						<a data-wysihtml5-command="createLink">Lien</a>
						
						<select class="styled-select">
							<option selected="selected">Syntaxe</option>
							<option value="math" data-class="math">Math</option>
							<option value="chimie" data-class="chimie">Chimie</option>
						</select>
						<div class="containerFakeSelect">
							<span class="valSelect"></span><span class="arrowSelect">v</span>
							<ul class="contVal">
								
							</ul><!-- /.contVal -->
						</div><!-- /.containerFakeSelect -->
						
						<div class="defineLink" data-wysihtml5-dialog="createLink" style="display: none;">
							<label>
								Lien&nbsp;:
								<input type="text" data-wysihtml5-dialog-field="href" value="http://" class="text">
							</label>
							<a class="btn btn-green" data-wysihtml5-dialog-action="save">OK</a> <a class="btn" data-wysihtml5-dialog-action="cancel">Cancel</a>
						</div>
					</div><!-- /#wysihtml5-toolbar -->
					<textarea name="message" id="wysihtml5-textarea"><?php if(isset($message)) echo $message; ?></textarea>
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
					<a class="btn btn-green" href="index.php?page=connexion">Te connecter</a>
					<a class="btn btn-blue" href="index.php?page=inscription">T'inscrire</a><br>
					<a class="btn backNotLoggedIn" href="index.php">Retour aux questions</a>
		</section><!-- /.actions -->
			<?php
					}
				}
			?>
	</div><!-- /.container -->
</div><!-- /.content -->