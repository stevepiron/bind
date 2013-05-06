<?php
	$__TITLE_PAGE__ = 'Inscription (étape 1/3) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'inscription';
	$level = '1';
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="../media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Inscription</h1>
		
		<form id="signUpForm" action="index.php?page=inscription-2" method="post">
			<div>
				<label for="email">Adresse email</label>
				<input type="email" name="email" id="email" value="" autocomplete="off" autofocus>
			</div>
			<div>
				<label for="password">Mot de passe</label>
				<input type="password" name="password" id="password" value="">
			</div>
			<input type="submit" class="btn btn-green" value="M'inscrire">
		</form>
		
	</div><!-- /.container -->
</div><!-- /.content -->