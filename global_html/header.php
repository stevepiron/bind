<?php
	$dig = '';
	
	if($level == 1) {
		$dig = '../';
	}
?>

<header class="clearfix">
	<div class="pp_loggedIn">
		<a href="<?php echo $dig; ?>index.php#loggedIn"><img id="logo" src="<?php echo $dig; ?>media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
	</div>
	<div class="pp_not_loggedIn">
		<a href="<?php echo $dig; ?>index.php"><img id="logo" src="<?php echo $dig; ?>media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
	</div>
	
	<a class="askForHelp btn btn-primary pp_loggedIn" href="#">Demander de l'aide</a>
	<div id="userAccount">
    	<a id="signIn" class="pp_not_loggedIn" href="<?php echo $dig; ?>index.php?page=connexion">Me connecter</a>
    	<a id="signUp" class="pp_not_loggedIn" href="<?php echo $dig; ?>index.php?page=inscription">M'inscrire</a>
    	
    	<div class="pp_loggedIn">
        	<button id="userAccountTrigger">
        		<img class="userAvatar" src="<?php echo $dig; ?>media/img/user/avatar@2x.png" alt="User name" width="36" height="36">
        		<span>Mon compte</span>
        	</button>
        	
        	
        	<div id="userDropdown" class="hidden">
        		<ul>
        			<li><a href="#">Mes demandes <span class="count">0</span></a></li>
        			<li><a href="#">Demandes surveillées <span class="count">2</span></a></li>
        			<li><a href="#">Mes élèves <span class="count">1</span></a></li>
        			<li><a id="signOff" href="<?php echo $dig; ?>index.php">Déconnexion</a></li>
        		</ul>
        	</div>
    	</div><!-- /.pp_loggedIn -->
	</div>
</header><!-- /header -->