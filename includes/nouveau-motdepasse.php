<?php
	$__TITLE_PAGE__ = 'Changer mon mot de passe • Bind';
	$__DESC_PAGE__ = '';
	$section = 'reset';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// Includes
	require 'php/functions.php';
	require 'php/constants.php';
	require 'php/database-connection.php';
	
	// Development window
/*
	echo '<div class="dev">';
		
		// Session variables
		echo '$id = '.$id.'<br>Utilisateur = '.$firstname.'<br>';
		
		if($_SESSION) {
			echo '<pre>Session en cours :<br>';
			print_r($_SESSION);
			echo '</pre>';
		}
	echo '</div><!-- /.dev -->';
*/
	

	
	
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Réinitialiser ton mot de passe</h1>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
			
			if($id != 0) {
				setError(ERR_LOGGEDIN); // If the user is already logged in
			}
			else {
		?>
		
		<form id="emailForReset" action="" method="post">
			<div>
				<label for="email">Adresse email</label>
				<input type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>">
			</div>
			<input type="submit" name="emailForReset" class="btn btn-green" value="Réinitialiser">
		</form>
		
		<p class="center switchSignInSignUp"><a href="index.php?page=inscription">Tu n'as pas encore de compte ?</a></p>
		
		<?php } ?>
		
	</div><!-- /.container -->
</div><!-- /.content -->