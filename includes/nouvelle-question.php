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
					<option value="math">Math</option>
					<option value="chimie">Chimie</option>
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