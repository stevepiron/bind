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
	 
	
	if(isset($_GET['email']) && isset($_GET['hash'])) {
		if($_GET['email'] && $_GET['hash']) {
			
			extract($_GET); // Creates variables from POST
			
			try {
				$sql = 'SELECT email, hash, active
						FROM users
						WHERE email = "'.$email.'"
						AND hash = "'.$hash.'"
						AND active = "0"';
			
				$res = $db -> query($sql);
				$user = $res -> fetchAll(PDO::FETCH_ASSOC);
				
				$match = count($user); // Count how many matches where found
				
				if($match == 1) {
					// We have a single match, activate the account
					try {
						$sql = 'UPDATE users
								SET active = "1"
								WHERE email = "'.$email.'"
								AND hash = "'.$hash.'"
								AND active = "0"';
						
						$db -> exec($sql);
						$feedback = '<p class="notice">Ton compte a été activé ! C\'est quoi ton prénom ?</p>';
								
					}
					catch(exception $e) {
						echo 'erreur : '.$e->getMessage();
					}
				}
				else {
					// No match: invalid url or account has already been activated
					$feedback = '<p class="notice">Le lien n\'est pas correct ou ton compte a déjà été activé.</p>';
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
		if(isset($_POST['setFirstname'])) {
			
			extract($_POST);
			$firstname = ucname(trim(strip_tags($firstname)));
			extract($_GET);
			
			try {
				$sql = 'UPDATE users
						SET firstname = "'.$firstname.'"
						WHERE email = "'.$email.'"
						AND hash = "'.$hash.'"
						AND active = "1"';
				
				$db -> exec($sql);
				$feedback = '<p>Enchanté, '.htmlentities($firstname).' !</p>
							<p>Tu peux dès à présent <a href="index.php?page=connexion&email='.urlencode($email).'">te connecter</a> pour poser tes questions ou aider les autres :)';
			}
			catch(exception $e) {
				echo 'erreur : '.$e->getMessage();
			}
			
		}
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
			if(isset($_GET['email']) && isset($_GET['hash'])) {
				if($_GET['email'] && $_GET['hash']) {
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