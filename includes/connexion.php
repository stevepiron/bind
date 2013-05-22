<?php
	$__TITLE_PAGE__ = 'Connexion • Bind';
	$__DESC_PAGE__ = '';
	$section = 'connexion';
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
	
	// If user comes from the activation page
	extract($_GET);
	$email = str_replace(' ', '+', urldecode($email)); // Decodes url and changes spaces to +
	
	if($_POST['login']) {
		// Define variables
		extract($_POST);
		
		if(isset($_POST['login'])) {
			
			// Define error variables as NULL
			// so that they're not rendered
			// if the error is not targeted
			$errors = 0;
			$error_emptyForm = NULL;
			$error_emptyEmail = NULL;
			$error_emailSyntax = NULL;
			$errors_emailNotRegistered = NULL;
			$error_emptyPassword = NULL;
			
			if(empty($email) && empty($password)) {
				// Both email and password fields are empty
				$errors++;
				$error_emptyForm = 'Aucun champ n\'a été rempli.';
			}
			else {
				// At least on field is filled
				
				// Email address verification
				if(empty($email)) {
					// Email field is empty
					$errors++;
					$error_emptyEmail = 'Il semblerait que tu aies oublié de renseigner ton adresse email.';
				}
				else {
					// Email field is not empty
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						// Email syntax is wrong
						$errors++;
						$error_emailSyntax = 'Tu dois mentionner une adresse email valide.';
					}
					else {
						// Email syntax is ok
						// Verify if the email address exists in the database
						$sql = "SELECT email
								FROM users
								WHERE email = '$email'";
						try {
							$res = $db -> query($sql);
							$count = $res -> fetchAll(PDO::FETCH_ASSOC);
						}
						catch(exception $e) {
							echo 'Erreur : '.$e -> getMessage();
						}
						if(empty($count)) {
							// This email address is not registered
							$errors++;
							$errors_emailNotRegistered = 'Cette adresse email n\'est pas associée à un compte existant.';
						}	
					}
				}
				
				// Password verification
				if(empty($password)) {
					// Password field is empty
					$errors++;
					$error_emptyPassword = 'Hé là-bas, pas trop vite ! Tu as oublié de renseigner ton mot de passe :)';
				}
			}
			
			/*
			 *  No error found
			 *  Attempt connection
			 */
			
			if($errors == 0) {
				
				$password = md5($password); // Converts password input to md5, as in the database
			
				$sql = 'SELECT *
						FROM users
						WHERE email ="'.$email.'"
						AND password ="'.$password.'"
						AND active = "1"';
				
				$res = $db -> query($sql);
				$user = $res -> fetchAll(PDO::FETCH_ASSOC);
				$match = count($user);
				
				if($match == 1) {
					// Login accepted
					session_start();
					$_SESSION['id'] = $user[0]['id'];
					$_SESSION['firstname'] = $user[0]['firstname'];
					$_SESSION['email'] = $user[0]['email'];
					$_SESSION['picture_url'] = $user[0]['picture_url'];
					$_SESSION['useful_answers'] = $user[0]['useful_answers'];
					$_SESSION['year'] = $user[0]['year'];
					
					redirect('index.php');
					//header('Location:'.$_SERVER['HTTP_REFERER']);
				}
				else {
					// Login denied: inactive account OR wrong login / password
					$feedback = '<p class="notice error center">Ce mot de passe est incorrect.</p>';
				}
			}
			else {
				// Errors found
				$feedback = '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyForm.'</li>';
				$feedback .= '<li>'.$error_emptyEmail.'</li>';
				$feedback .= '<li>'.$error_emailSyntax.'</li>';
				$feedback .= '<li>'.$errors_emailNotRegistered.'</li>';
				$feedback .= '<li>'.$error_emptyPassword.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
			}
		}
	}
	else {
		// The form has not been submitted yet.
		// This case happens when the user is
		// redirected to this page after the
		// activation of his/her account.
		if($_GET['nom']) {
			extract($_GET);
			
			if(isset($_GET['nom'])) {
				$feedback = '<p class="notice success center">Bienvenue, '.$nom.' !</p>';
			}
		}
	}
	
	
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Connexion</h1>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
			
			if($id != 0) {
				setError(ERR_LOGGEDIN); // If the user is already logged in
			}
			else {
		?>
		
		<form id="signInForm" action="" method="post">
			<div>
				<label for="email">Adresse email</label>
				<input type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>">
			</div>
			<div>
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password">
				<p class="helpText"><a href="#">Mot de passe oublié&nbsp;?</a></p>
			</div>
			<input type="submit" name="login" class="btn btn-green" value="Connexion">
		</form>
		
		<p class="center switchSignInSignUp"><a href="index.php?page=inscription">Tu n'as pas encore de compte ?</a></p>
		
		<?php } ?>
		
	</div><!-- /.container -->
</div><!-- /.content -->