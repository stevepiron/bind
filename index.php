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
			
			case 'demande':
				include('global_html/header.php');
				include('includes/demande.php');
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