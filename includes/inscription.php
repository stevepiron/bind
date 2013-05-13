<?php
	$__TITLE_PAGE__ = 'Inscription (étape 1/3) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'inscription';
	$level = '1';
	
	echo '<div class="dev">';
		require 'php/database-connection.php';
	echo '</div><!-- /.dev -->';
	
	if(isset($_POST['signUp'])) {
		if($_POST['signUp']) {
			
			extract($_POST); // Creates variables from POST
			$email = strtolower(trim(strip_tags($email)));
			$password = trim(strip_tags($password));
			
			/*
			 *  Error handling
			 */
			
			$error = 0;
			$feedback = '';
			
			
			if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error = 1;
				$feedback .=  '<p class="notice error">L\'adresse email mentionnée n\'est pas valide.</p>';
			} 
			if(empty($password)) {
				$error = 1;
				$feedback .=  '<p class="notice error">Tu dois choisir un mot de passe.</p>';
			}
			
			if(!$error) {
				try {
					$hash = md5(rand(0,1000)); // Random 32 chars. hash
					$password = md5($password);
					
					$sql = "INSERT INTO users (email, password, hash)
							VALUES ('$email', '$password', '$hash')";
							
					$count = $db -> exec($sql); // Returns the number of insertions
					$feedback = 'Ton compte a bien été créé ! Un email t\'a été envoyé afin de le valider.';
				
					require 'php/signup-email.inc.php';	
				}
				catch(exception $e) {
					echo 'erreur : '.$e->getMessage();
				}
				
				
			}
			
		}
	}
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Inscription</h1>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
		?>
		
		<form id="signUpForm" action="" method="post">
			<div>
				<label for="email">Adresse email</label>
				<input type="email" name="email" id="email" value="" autocomplete="off" autofocus>
			</div>
			<div>
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password" value="">
			</div>
			<input type="submit" name="signUp" class="btn btn-green" value="M'inscrire">
		</form>
		
	</div><!-- /.container -->
</div><!-- /.content -->