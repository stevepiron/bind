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
						COUNT(*) AS count
					FROM requests
					WHERE requests.fk_author = ".$id;
			$res = $db -> query($sql);
		}
		catch(exception $e) {
			'Erreur lors du compte du nombre de questions que tu as posées : '.$e -> getMessage();
		}
		$res = $res -> fetchAll(PDO::FETCH_ASSOC);
		$myRequestsNumber = $res[0]['count'];
	}
	
?>

<header role="main-header">
	<a id="logoHeader" href="<?php echo $dig; ?>index.php"><img class="logo" src="<?php echo $dig; ?>media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"> Bind</a>
	
	<?php if($_SESSION && $id != 0): ?>
	
	
	<div id="userAccount">
    	<button id="userAccountTrigger">
    		<img class="userAvatar" src="<?php echo $dig; ?><?php if(isset($picture_url)) echo $picture_url; ?>" alt="<?php if(isset($firstname)) echo 'Ma photo ('.$firstname.')'; ?>" width="36" height="36">
    		<span>Ton compte</span>
    	</button>
    	
    	<div id="userDropdown" class="hidden">
    		<ul>
    			<li><a href="#">Tes questions <span class="count"><?php echo $myRequestsNumber; ?></span></a></li>
    			<!-- <li><a href="#">Questions surveillées <span class="count">2</span></a></li> -->
    			<!-- <li><a href="#">Mes élèves <span class="count">1</span></a></li> -->
    			<li><a href="index.php?page=mon-compte">Gérer ton compte</a></li>
    			<li><a id="signOff" href="php/logout.php">Déconnexion</a></li>
    		</ul>
    	</div>
	</div>
	<?php else: ?>
	<div id="userAccount">
		<a id="signIn" href="<?php echo $dig; ?>index.php?page=connexion">Te connecter</a>
		<a id="signUp" href="<?php echo $dig; ?>index.php?page=inscription">T'inscrire</a>
	</div><!-- /#userAccount -->
	<?php endif ?>
</header><!-- /header -->