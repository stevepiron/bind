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
			
			// Define error variables as NULL
			// so that they're not rendered
			// if the error is not targeted
			$errors = 0;
			$feedback = '';
			$error_emptyEmail = NULL;
			$error_emailSyntax = NULL;
			$error_emailAlreadyUsed = NULL;
			$error_emptyPassword = NULL;
			
			/*
			 *  Error handling
			 */
			
			// Email verification
			if(empty($email)) {
				$errors++;
				$error_emptyEmail =  'Tu n\'as pas renseigné d\'adresse email.';
			} 
			else {
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors++;
					$error_emailSyntax = 'L\'adresse email renseignée n\'est pas valide.';
				}
				
				// Email address verification
				$sql = "SELECT id, email
					FROM users
					WHERE email = '$email'
					AND id <> '$id'"; // id ≠ $id
				try {
					$res = $db -> query($sql); // Find if there is another user already using this email address
					$count = $res -> fetchAll(PDO::FETCH_ASSOC);
				}
				catch(exception $e) {
					echo 'Erreur : '.$e -> getMessage();
				}
				if(!empty($count)) {
					// Someone other than you already uses this email address
					$errors++;
					$error_emailAlreadyUsed = 'Cette adresse email est déjà associée à un compte.';
				}
			}
			
			// Password verification
			if(empty($password)) {
				$errors++;
				$error_emptyPassword =  'Tu dois choisir un mot de passe.';
			}
			
			/*
			 *  No error found
			 *  Update the database
			 */
			
			if($errors == 0) {
				try {
					$hash = md5(time()+rand(10,1100));
					$securePassword = md5($password);
					
					$sql = "INSERT INTO users (email, password, hash)
							VALUES ('$email', '$securePassword', '$hash')";
							
					$count = $db -> exec($sql); // Returns the number of insertions
					
					$feedback = '<div class="notice success wide">';
					$feedback .= 'Ton compte a bien été créé ! Un email t\'a été envoyé à <span class="bold">'.$email.'</span> afin de le valider.';
					$feedback .= '</div><!-- /.notice -->';
				
					require 'php/signup-email.inc.php';	
				}
				catch(exception $e) {
					echo 'erreur : '.$e->getMessage();
				}
				
				// Reset input fields so that they're not filled again
				// after submission
				$email = '';
				$password = '';
			}
			else {
				// Errors found
				$feedback = '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyEmail.'</li>';
				$feedback .= '<li>'.$error_emailSyntax.'</li>';
				$feedback .= '<li>'.$error_emailAlreadyUsed.'</li>';
				$feedback .= '<li>'.$error_emptyPassword.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
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
				<input type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>" autocomplete="off" autofocus>
			</div>
			<div>
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password" value="<?php if(isset($password)) echo $password; ?>">
			</div>
			<input type="submit" name="signUp" class="btn btn-green" value="M'inscrire">
		</form>
		
		<p class="center switchSignInSignUp"><a href="index.php?page=connexion">Tu as déjà un compte ?</a></p>
		
	</div><!-- /.container -->
</div><!-- /.content -->