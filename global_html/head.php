<?php
	$dig = '';
	
	/*
if($level == 1) {
		$dig = '../';
	}
*/
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $__TITLE_PAGE__; ?></title>
        <meta name="author" content="Steve Piron (@stevepiron)">
        <meta name="description" content="<?php echo $__DESC_PAGE__; ?>">
        <meta name="viewport" content="width=device-width">
        
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $dig ?>media/img/assets/icons/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $dig ?>media/img/assets/icons/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $dig ?>media/img/assets/icons/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $dig ?>media/img/assets/icons/apple-touch-icon-57x57-precomposed.png">

        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $dig ?>ui/css/main.min.css">
        <script src="<?php echo $dig ?>ui/js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body class="<?php echo $section ?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->