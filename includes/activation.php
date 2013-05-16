<?php
	$__TITLE_PAGE__ = 'Inscription (étape 2/3) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'inscription';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// Includes
	require 'php/functions.php';
	require 'php/constants.php';
	
	// Development window
	echo '<div class="dev">';
		require 'php/database-connection.php';
		
		// Session variables
		echo '$id = '.$id.'<br>Utilisateur = '.$firstname.'<br>';
		
		if($_SESSION) {
			echo '<pre>Session en cours :<br>';
			print_r($_SESSION);
			echo '</pre>';
		}
	echo '</div><!-- /.dev -->';
		
	/*
	 *  User account activation
	 */
	 
	if(isset($_GET['hash'])) {
		if($_GET['hash']) {
			
			extract($_GET); // Creates variables from POST
			
			try {
				$sql = 'SELECT hash, active
						FROM users
						WHERE hash = "'.$hash.'"
						AND active = "0"';
			
				$res = $db -> query($sql);
				$user = $res -> fetchAll(PDO::FETCH_ASSOC);
				
				$match = count($user); // Count how many matches where found
				
				if($match == 1) {
					// We have a single match, activate the account
					try {
						$sql = 'UPDATE users
								SET active = "1"
								WHERE hash = "'.$hash.'"
								AND active = "0"';
						$db -> exec($sql);
					}
					catch(exception $e) {
						echo 'erreur : '.$e->getMessage();
					}
					$feedback = '<p class="notice success">Ton compte a été activé ! C\'est quoi ton prénom ?</p>';
				}
				else {
					// No match: invalid url or account has already been activated
					$feedback = '<p class="notice error">Le lien n\'est pas correct ou ton compte a déjà été activé.</p>';
				}
			}
			catch(exception $e) {
				echo 'erreur : '.$e->getMessage();
			}
			
			
		}
	}
	else {
		// Invalid approach
		$feedback = '<p>Ah PD faut d truk dans l\'url mek!!! J\'parie 2 cents que c\'est Bastien !!! Ou MAKS !!!!!!!!</p>
				<p>Faut pas que j\'oublie de changer ça pour le tfou hihi</p>';
	}
	
	/*
	 *  Set firstname
	 */

	if($_POST['setFirstname']) {
		// Form has already been displayed once
		// so we can say we have one match
		$match = 1; // Allows setFirstname to be shown more than once
		extract($_POST);
		
		if(isset($_POST['setFirstname'])) {
			$firstname = ucname(trim(strip_tags($firstname)));
			
			// Define error variables as NULL
			// so that they're not rendered
			// if the error is not targeted
			$errors = 0;
			$error_emptyFirstname = NULL;
			$error_firstnameLength = NULL;
			
			if(empty($firstname)) {
				// Firstname field is empty
				$errors++;
				$error_emptyFirstname = 'Tu n\'as pas renseigné ton prénom.';
			}
			else {
				// Firstname field is filled
				if(strlen($firstname) > 20) {
					// Firstname is longer than 20 chars.
					$errors++;
					$error_firstnameLength = 'Ton prénom ne peut dépasser 20 caractères.';
				}
			}
			
			if($errors == 0) {
				try {
					$sql = 'UPDATE users
							SET firstname = "'.$firstname.'"
							WHERE hash = "'.$hash.'"
							AND active = "1"';
					
					$db -> exec($sql);
				}
				catch(exception $e) {
					echo 'erreur : '.$e->getMessage();
				}
				redirect('index.php?page=connexion&nom='.urlencode($firstname));
			}
			else {
				// Errors found
				$feedback = '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyFirstname.'</li>';
				$feedback .= '<li>'.$error_firstnameLength.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
			}
		}
	}
	else {
		// Prefer an empty string to a 0
		// if the page is refreshed and therefore
		// the firstname has not been set
		$firstname = '';
	}
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Activation</h1>
		
		<?php
			echo $feedback;
		?>
		
		<?php
			if(isset($_GET['hash'])) {
				if($_GET['hash']) {
					if($match == 1) {
		?>
		<form action="" method="post">
			<input type="text" name="firstname">
			<input type="submit" name="setFirstname" class="btn btn-green" value="Enchanté !">
		</form>
		<?php
					}
				}
			}
		?>
		
	</div><!-- /.container -->
</div><!-- /.content -->