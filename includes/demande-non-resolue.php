<?php
	$__TITLE_PAGE__ = 'Nomenclature (chimie) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'demande';
	$level = '1';
?>

<div class="content">
	<div class="container">
		<h1><a href="index.php">Lycée Emile Jacqmain</a></h1>
		
		<section class="request">
			<header>
				<h2 class="pp_loggedIn"><a href="index.php?page=demande-non-resolue#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				<h2 class="pp_not_loggedIn"><a href="index.php?page=demande-non-resolue">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
			</header>
			
			<aside>
				<ul>
					<li class="author"><img src="media/img/user/user-male-2@2x.png" alt="" width="48" height="48"> Maxime</li>
					<li class="bestAnswersCount" title="122 réponses utiles">122</li>
					<li class="publishedDate">Il y a 2 jours</li>
				</ul>
			</aside>
			
			<article>
				<p>J'ai raté le dernier cours (M. Danterre), je me suis mis en ordre au niveau de la théorie que j'ai déjà relue pas mal de fois mais j'ai vraiment du mal à les appliquer aux exercices... Quelqu'un qui a compris pourrait m'expliquer ? Merci !</p>
			
				<footer>
					<a class="btn pp_loggedIn" href="index.php?page=demande-non-resolue#commentForm">Répondre</a>
					<p><a class="answers" href="index.php?page=demande-non-resolue#interactions_and_loggedIn">0 réponse</a> • <a class="interest" href="">1 intéressé</a></p>
					<div class="interestedUsersFaces">
						<img src="media/img/user/user-female-2@2x.jpg" alt="" width="48" height="48">
						<img src="media/img/user/user-female-4@2x.jpg" alt="" width="48" height="48">
						<img src="media/img/user/user-male-3@2x.jpg" alt="" width="48" height="48">
					</div><!-- /.interestedUsersFaces -->
				</footer>
			</article>
		</section><!-- /.request -->
		
		<section id="interactions">
			<section class="actions">
				<a class="btn pp_loggedIn_and_not_commenting" href="#pp_toggle_commenting">Répondre</a>
				
				<form id="commentForm" class="pp_loggedIn_and_commenting clearfix" action="#" method="post">
					<img class="userAvatar rounded" src="<?php echo $dig; ?>media/img/user/avatar@2x.png" alt="User name" width="48" height="48">
					<textarea name="comment" id="comment"></textarea>
					<input type="submit" class="btn btn-green" value="Envoyer ma réponse">
				</form><!-- /#commentForm -->
			</section><!-- /.actions -->
		</section><!-- /#interactions -->
	</div><!-- /.container -->
</div><!-- /.content -->