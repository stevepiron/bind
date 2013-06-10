<?php
	$__TITLE_PAGE__ = 'Nouvelle question • Bind';
	$__DESC_PAGE__ = '';
	$section = 'nouvelle-question';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// Includes
	require_once 'php/functions.php';
	require_once 'php/constants.php';
	
	// Development window	
/*
	echo '<div class="dev">';
		
		// Session variables
		echo 'Variables de session :<br>$id = '.$id.'<br>Utilisateur = '.$firstname.'<br>';
		
		// Current session
		if($_SESSION) {
			echo '<pre>Session en cours :<br>';
			print_r($_SESSION);
			echo '</pre>';
		}
		
	echo '</div><!-- /.dev -->';
*/
	
	/*
	 *  Gather all categories
	 */
	
	try {
		$sql = "SELECT
					c.id,
					c.category
				FROM categories c
				ORDER BY c.category ASC";
		$res = $db -> query($sql);
		$categories = $res -> fetchAll(PDO::FETCH_ASSOC);
	}
	catch(exception $e) {
		'Erreur lors de la récupération de la liste des cours : '.$e -> getMessage();
	}
	$categoriesOptionsList = listCategories($categories); // Then echo this in the html at the right place
	
	if($id != 0) {
		// User is logged in
		if($_POST['newRequest']) {
			if(isset($_POST['newRequest'])) {
				extract($_POST);
				$title = trim(strip_tags($title));
				$requestMessage = trim($request);
				$now = date('Y-m-d H:i:s');
				
				// Define error variables as NULL
				// so that they're not rendered
				// if the error is not targeted
				$errors = 0;
				$error_emptyTitle = NULL;
				$error_emptyRequestMessage = NULL;
				
				/*
				 *  Error handling
				 */
				
				// Title verification
				if(empty($title)) {
					$errors++;
					$error_emptyTitle = 'Il faut un titre à ta question.';
				}
				
				// Message verification
				if(empty($requestMessage)) {
					$errors++;
					$error_emptyRequestMessage = 'Ben alors ? Tu n\'avais pas une question à poser ? :)';
				}
				
				/*
				 *  No error found
				 *  Insert into the database
				 */
				 
				if($errors == 0) {
					$sql = "INSERT INTO requests (fk_category, priority, title, message, date, fk_author)
									VALUES ('$category', '$priority', '$title', '$requestMessage', '$now', '$id');";
					try {
						$db -> exec($sql);
					}
					catch(exception $e) {
						'Erreur lors de l\'ajout de ta question dans la base de données : '.$e -> getMessage();	
					}
					
					$feedback = '<p class="notice success">Ta demande a bien été envoyée. Elle se trouve désormais exposée à <a href="index.php">toute l\'école</a> :)</p>';
				}
				// Errors found
				else {
					$feedback = '<ul class="notice error">';
					$feedback .= '<li>'.$error_emptyTitle.'</li>';
					$feedback .= '<li>'.$error_emptyRequestMessage.'</li>';
					$feedback .= '</ul><!-- /.notice -->';
				}
			}
		}
	}
	
	// Development purposes
/*
	echo '<div class="devbox"><pre>Résultat de la requête (cours) :<br>';
		print_r($categories);
	echo '</pre></div><!-- /.devbox -->';
*/
	
?>

<div class="content">
	<div class="container">
		
		<header role="page-header">
			<div>
				<h1>Pose une question</h1>
			</div>
		</header>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
		?>
		
		<form id="newRequest" action="" method="post">
			<div class="halfWidthSelect">
				<label for="category">Cours concerné</label>
				<select name="category" id="category" class="styled-select">
					<?php echo $categoriesOptionsList; ?>
				</select>
				<div class="containerFakeSelect">
					<span class="valSelect"></span><span class="arrowSelect">v</span>
					<ul class="contVal">
						
					</ul><!-- /.contVal -->
				</div><!-- /.containerFakeSelect -->
			</div>
			<div class="halfWidthSelect">
				<label for="priority">Priorité</label>
				<select name="priority" id="category" class="styled-select">
					<option value="0" selected>Importante</option>
					<option value="1">Urgente</option>
				</select>
				<div class="containerFakeSelect">
					<span class="valSelect"></span><span class="arrowSelect">v</span>
					<ul class="contVal">
						
					</ul><!-- /.contVal -->
				</div><!-- /.containerFakeSelect -->
			</div>
			<div>
				<label for="title">Quelle est ta question&nbsp;?</label>
				<input type="text" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>">
			</div>
			<div>
				<label for="request">Explique ton problème</label>
				<div id="wysihtml5-toolbar" style="display: none;">
					<a data-wysihtml5-command="bold">Gras</a>
					
					<!-- Some wysihtml5 commands like 'createLink' require extra paramaters specified by the user (eg. href) -->
					<a data-wysihtml5-command="createLink">Lien</a>
					<div data-wysihtml5-dialog="createLink" style="display: none;">
						<label>
							Link:
							<input type="text" data-wysihtml5-dialog-field="href" value="http://" class="text">
						</label>
						<a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancel</a>
					</div>
				</div><!-- /#wysihtml5-toolbar -->
				<textarea name="request" id="wysihtml5-textarea"><?php if(isset($requestMessage)) echo $requestMessage; ?></textarea>
			</div>
			<input type="submit" name="newRequest" class="btn btn-green" value="Envoyer ma question">
		</form>
		
	</div><!-- /.container -->
</div><!-- /.content -->