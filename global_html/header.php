<?php
	$dig = '';
	
	/*
	if($level == 1) {
			$dig = '../';
		}
	*/
	
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	extract($_SESSION);
	
	// Includes
	require 'php/functions.php';
	require 'php/constants.php';
	require 'php/database-connection.php';

	// Development window
/*
	echo '<div class="dev">';
	
		require 'php/database-connection.php';
		
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

	if($id != 0) {
		// User is logged in
		try {
			$sql = "SELECT 
						COUNT(*)
					FROM requests
					WHERE requests.fk_author = ".$id;
			$res = $db -> query($sql);
			$res = $res -> fetchAll(PDO::FETCH_ASSOC);
			$myRequestsNumber = $res[0]['COUNT(*)'];
		}
		catch(exception $e) {
			'Erreur lors du compte du nombre de questions que tu as posées : '.$e -> getMessage();
		}
	}
	
?>

<header class="clearfix">
	<a id="logoAnchor" href="<?php echo $dig; ?>index.php"><img id="logo" src="<?php echo $dig; ?>media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"> Lycée Emile Jacqmain</a>
	
	<?php if($_SESSION && $id != 0): ?>
	<a class="askForHelp btn btn-primary" href="index.php?page=nouvelle-demande">Demander de l'aide</a>
	
	<div id="userAccount">
    	<button id="userAccountTrigger">
    		<img class="userAvatar" src="<?php echo $dig; ?><?php if(isset($picture_url)) echo $picture_url; ?>" alt="<?php if(isset($firstname)) echo 'Ma photo ('.$firstname.')'; ?>" width="36" height="36">
    		<span>Mon compte</span>
    	</button>
    	
    	<div id="userDropdown" class="hidden">
    		<ul>
    			<li><a href="#">Mes questions <span class="count"><?php echo $myRequestsNumber; ?></span></a></li>
    			<!-- <li><a href="#">Questions surveillées <span class="count">2</span></a></li> -->
    			<!-- <li><a href="#">Mes élèves <span class="count">1</span></a></li> -->
    			<li><a href="index.php?page=mon-compte">Gérer mon compte</a></li>
    			<li><a id="signOff" href="php/logout.php">Déconnexion</a></li>
    		</ul>
    	</div>
	</div>
	<?php else: ?>
	<div id="userAccount">
		<a id="signIn" href="<?php echo $dig; ?>index.php?page=connexion">Me connecter</a>
		<a id="signUp" href="<?php echo $dig; ?>index.php?page=inscription">M'inscrire</a>
	</div><!-- /#userAccount -->
	<?php endif ?>
</header><!-- /header -->