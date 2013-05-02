<?php
	$__TITLE_PAGE__ = 'Connexion • Bind';
	$__DESC_PAGE__ = '';
	$section = 'connexion';
	$level = '1';
?>

<header class="clearfix">
	<a href="../index.php"><img id="logo" src="../media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Connexion</h1>
		
		<form id="signInForm" action="../index.php#loggedIn" method="post">
			<div>
				<label for="email">Adresse email</label>
				<input type="email" name="email" id="email" value="hi@stevepiron.be">
			</div>
			<div>
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password" value="password">
			</div>
			<input type="submit" class="btn btn-green" value="Connexion">
		</form>
		
	</div><!-- /.container -->
</div><!-- /.content -->