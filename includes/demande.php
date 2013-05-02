<?php
	$__TITLE_PAGE__ = 'Nomenclature (chimie) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'demande';
	$level = '1';
?>

<div class="content">
	<div class="container">
		<h1>Lycée Emile Jacqmain</h1>
		
		<section class="request clearfix">
			<header class="clearfix">
				<h2 class="pp_loggedIn"><a href="index.php?page=demande#loggedIn">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
				<h2 class="pp_not_loggedIn"><a href="index.php?page=demande">Nomenclature</a> <a class="label" href="#">Chimie</a></h2>
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
					<a class="btn btn-green pp_loggedIn" href="#">Proposer une remédiation</a>
					<a class="btn pp_loggedIn" href="index.php?page=demande#commentForm">Répondre</a>
					<p><a class="answers" href="index.php?page=demande#interactions_and_loggedIn">2 réponses</a> • <a class="interest" href="">3 intéressés</a></p>
					<div id="interestedUsersFaces">
						<img src="../media/img/user/user-female-2@2x.jpg" alt="" width="48" height="48">
						<img src="../media/img/user/user-female-4@2x.jpg" alt="" width="48" height="48">
						<img src="../media/img/user/user-male-3@2x.jpg" alt="" width="48" height="48">
					</div><!-- /.interestedUsersFaces -->
				</footer>
			</article>
		</section><!-- /.request -->
		
		<section id="interactions">
			<ol class="comments">
				<li class="clearfix">
					<aside>
						<img src="../media/img/user/user-female-2@2x.jpg" alt="" width="48" height="48">
					</aside>
					<article>
						<header>
							<p class="author">Justine</p>
						</header>
						<p>Moi aussi j'ai eu beaucoup de mal au début :/ c'est quelle prof que tu as ?</p>
						<footer>
							<span class="publishedDate">Il y a 2 jours</span>
						</footer>
					</article>
				</li>
				<li class="clearfix">
					<aside>
						<img src="../media/img/user/user-female-1@2x.jpg" alt="" width="48" height="48">
					</aside>
					<article>
						<header>
							<p class="author">Stéphanie</p>
						</header>
						<p>C'est Bruneau...</p>
						<footer>
							<span class="publishedDate">Il y a 2 jours</span>
						</footer>
					</article>
				</li>
				<li class="clearfix bestAnswer">
					<aside>
						<span class="star">Meilleure réponse</span>
						<img src="../media/img/user/user-male-1@2x.jpg" alt="" width="48" height="48">
					</aside>
					<article>
						<header>
							<p class="author">Julien</p>
						</header>
						<p>Je t'ai fait une petite synthèse qui reprend mes trucs et astuces. <a href="#">http://d.pr/i/xBN6</a></p>
						<footer>
							<span class="publishedDate">Il y a 2 jours</span>
						</footer>
					</article>
				</li>
				<li class="clearfix">
					<aside>
						<img src="../media/img/user/user-female-1@2x.jpg" alt="" width="48" height="48">
					</aside>
					<article>
						<header>
							<p class="author">Stéphanie</p>
						</header>
						<p>Cool, merci beaucoup Ju !</p>
						<footer>
							<span class="publishedDate">Il y a 2 jours</span>
						</footer>
					</article>
				</li>
			</ol><!-- /.comments -->
			
			<section class="actions">
				<a class="btn btn-green pp_loggedIn_and_not_commenting" href="#">Proposer une remédiation</a>
				<a class="btn pp_loggedIn_and_not_commenting" href="#pp_toggle_commenting">Répondre</a>
				
				<form id="commentForm" class="pp_loggedIn_and_commenting" action="#" method="post">
					<textarea name="comment" id="comment"></textarea>
					<input type="submit" class="btn btn-green" value="Envoyer">
				</form><!-- /#commentForm -->
			</section><!-- /.actions -->
		</section><!-- /#interactions -->
	</div><!-- /.container -->
</div><!-- /.content -->