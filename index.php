<?php
	
	$__TITLE_PAGE__ = '';
	$__DESC_PAGE__ = '';
	$level = '';
	
	ob_start();
	if(!empty($_GET['page'])){
	
		switch($_GET['page']){
			
			case 'home':
				include('global_html/header.php');
				include('includes/home.php');
			break;
			
			case 'connexion':
				include('includes/connexion.php');
			break;
			
			case 'inscription':
				include('includes/inscription.php');
			break;
			
			case 'reset':
				include('includes/nouveau-motdepasse.php');
			break;
			
			case 'activation':
				include('includes/activation.php');
			break;
			
			case 'mon-compte':
				include('global_html/header.php');
				include('includes/mon-compte.php');
			break;
			
			case 'question':
				include('global_html/header.php');
				include('includes/question.php');
			break;
			
			case 'nouvelle-question':
				include('global_html/header.php');
				include('includes/nouvelle-question.php');
			break;
			
			case 'tes-questions':
				include('global_html/header.php');
				include('includes/tes-questions.php');
			break;
			
			default:
				include('includes/404.html');
			break;
		}
	}
	else{
		include('global_html/header.php');
		include('includes/home.php');
	}
	$content = ob_get_clean();
	
	include('global_html/head.php');
	
	echo $content;
	
	include('global_html/footer.php');
	
?>