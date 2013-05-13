<?php
	$__TITLE_PAGE__ = 'Connexion • Bind';
	$__DESC_PAGE__ = '';
	$section = 'connexion';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// If user comes from the activation page
	extract($_GET);
	$email = str_replace(' ', '+', urldecode($email)); // Decodes url and changes spaces to +
	
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
	
	if($_POST['login']) {
		if(isset($_POST['login'])) {
			
			extract($_POST);
			$password = md5($password); // Converts password input to md5, as in the DB
			
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
				
				echo '<pre>';
				print_r($_SESSION);
				echo '</pre><br>';
				
				header('Location: index.php');
			}
			else {
				// Login denied: inactive account OR wrong login / password
				$feedback = '<p class="notice error">Oups, problème !</p>';
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
			</div>
			<input type="submit" name="login" class="btn btn-green" value="Connexion">
		</form>
		<?php } ?>
		
	</div><!-- /.container -->
</div><!-- /.content -->