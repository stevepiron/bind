<?php
	
	$__TITLE_PAGE__ = '';
	$__DESC_PAGE__ = '';
	$level = '';
	
	ob_start();
	if(!empty($_GET['page'])){
	
		switch($_GET['page']){
	
			case 'connexion':
				include('includes/connexion.php');
			break;
			
			case 'inscription':
				include('includes/inscription.php');
			break;
			
			case 'activation':
				include('includes/activation.php');
			break;
			
			case 'demande-non-resolue':
				include('global_html/header.php');
				include('includes/demande-non-resolue.php');
			break;
			
			case 'demande-urgente':
				include('global_html/header.php');
				include('includes/demande-urgente.php');
			break;
			
			case 'demande-resolue':
				include('global_html/header.php');
				include('includes/demande-resolue.php');
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