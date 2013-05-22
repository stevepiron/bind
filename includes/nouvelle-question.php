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
	
	
	// Development purposes
/*
	echo '<div class="devbox"><pre>Résultat de la requête (cours) :<br>';
		print_r($categories);
	echo '</pre></div><!-- /.devbox -->';
*/
	
?>

<div class="content">
	<div class="container">
		
		<h1>Demander de l'aide</h1>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
		?>
		
		<form id="newRequest" action="" method="post">
			<div class="halfWidthSelect">
				<label for="category">Cours concerné</label>
				<select name="category" id="category">
					<?php echo $categoriesOptionsList; ?>
				</select>
			</div>
			<div class="halfWidthSelect">
				<label for="priority">Priorité</label>
				<select name="priority" id="category">
					<option value="0">Importante</option>
					<option value="1">Urgente</option>
				</select>
			</div>
			<div>
				<label for="title">Titre de ta demande</label>
				<input type="text" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>">
			</div>
			<div>
				<label for="request">Demande</label>
				<textarea type="request" name="request" id="request"></textarea>
			</div>
			<input type="submit" name="newRequest" class="btn btn-green" value="Envoyer ma demande">
		</form>
		
	</div><!-- /.container -->
</div><!-- /.content -->