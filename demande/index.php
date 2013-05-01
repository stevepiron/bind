<?php $title = 'Nomenclature (chimie) • Bind'; $section = 'demande'; $level ='1'; include('../includes/head.php'); ?>

<?php include('../includes/header.php'); ?>

<div class="content">
	<div class="container">
		<h1>Lycée Emile Jacqmain</h1>
		
		<section class="request clearfix">
			<header class="clearfix">
				<h2 class="pp_loggedIn"><a href="demande/index.php#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				<h2 class="pp_not_loggedIn"><a href="demande/index.php">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
			</header>
			
			<aside>
				<ul>
					<li class="author"><img src="../media/img/user/user-female-1@2x.jpg" alt="" width="48" height="48"> Stéphanie</li>
					<li class="publishedDate">Il y a 2 jours</li>
				</ul>
			</aside>
			
			<article>
				<p>Je n’arrive pas à comprendre la nomenclature malgré les exercices de révision que la prof m’a donnés. J’ai un gros test le 28 avril ! Quelqu’un pour m’aider ?</p>
			
				<footer>
					<a class="btn btn pp_loggedIn" href="#">Proposer une remédiation</a>
					<a class="btn pp_loggedIn" href="demande/index.php#commentForm">Répondre</a>
					<p><a class="answers" href="demande/index.php#interactions_and_loggedIn">2 réponses</a> • <a class="interest" href="">3 intéressés</a></p>
				</footer>
			</article>
		</section><!-- /.request -->
		
		<section id="interactions">
			<ol class="comments">
				<li class="clearfix">
					<aside>
						<ul>
							<li class="author"><img src="../media/img/user/user-female-2@2x.jpg" alt="" width="48" height="48"> Justine</li>
							<li class="publishedDate">Il y a 2 jours</li>
						</ul>
					</aside>
					<p>Moi aussi j'ai eu beaucoup de mal au début :/ c'est quelle prof que tu as ?</p>
				</li>
				<li class="clearfix">
					<aside>
						<ul>
							<li class="author"><img src="../media/img/user/user-male-2@2x.png" alt="" width="48" height="48"> Adrien</li>
							<li class="publishedDate">Hier</li>
						</ul>
					</aside>
					<p>Mdr sa crin looool bn chance ^^</p>
				</li>
			</ol><!-- /.comments -->
			
			
			<a class="btn btn-green pp_loggedIn_and_not_commenting" href="#">Proposer une remédiation</a>
			<a class="btn pp_loggedIn_and_not_commenting" href="#pp_toggle_commenting">Commenter</a>
			
			<form id="commentForm" class="pp_loggedIn_and_commenting" action="#" method="post">
				<textarea name="comment" id="comment"></textarea>
				<input type="submit" class="btn btn-green" value="Envoyer">
			</form><!-- /#commentForm -->
		</section><!-- /#interactions -->
	</div><!-- /.container -->
</div><!-- /.content -->

<?php include('../includes/footer.php'); ?>