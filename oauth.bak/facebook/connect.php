<?php
	
	require 'api/facebook.php';
	
	/*
	 *  Facebook object initialization
	 */
	
	$facebook = new Facebook(array(
		'appId' => '256988517779393',
		'secret' => 'c333ff5a896bfa071bb3f3be354183d4',
		'cookie' => true
	));
	
	// Get User ID
	$facebookUser = $facebook->getUser();
	
	if($facebookUser) {
		try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $facebookUserProfile = $facebook->api('/me');
		} catch (FacebookApiException $e) {
		    error_log($e);
		    $facebookUser = null;
		}
		echo '<pre>';
		print_r($facebookUserProfile);
		echo '</pre>';
		$facebookLogoutUrl = $facebook->getLogoutUrl();
	} else {
		$facebookLoginUrl = $facebook->getLoginUrl();
	}
	
?>