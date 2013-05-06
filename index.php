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
			
			case 'inscription-1':
				include('includes/inscription-1.php');
			break;
			
			case 'inscription-2':
				include('includes/inscription-2.php');
			break;
			
			case 'inscription-3':
				include('includes/inscription-3.php');
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