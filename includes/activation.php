<?php
	$__TITLE_PAGE__ = 'Inscription (étape 2/3) • Bind';
	$__DESC_PAGE__ = '';
	$section = 'inscription';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// Includes
	require 'php/functions.php';
	require 'php/constants.php';
	
	// Development window
	echo '<div class="dev">';
		require 'php/database-connection.php';
		
		// Session variables
		echo '$id = '.$id.'<br>Utilisateur = '.$firstname.'<br>';
		
		if($_SESSION) {
			echo '<pre>Session en cours :<br>';
			print_r($_SESSION);
			echo '</pre>';
		}
	echo '</div><!-- /.dev -->';
		
	
	 
	if(isset($_GET['hash'])) {
		extract($_GET); // Creates variables from GET
		
		if($_GET['hash']) {
			
			if($id != 0) {
				// The user is logged in:
				// display an error in the html (see below)
				// as he/she shouldn't be here
			}
			else {
				// The user is not logged in
				// and more likely comes from
				// the url provided in the email
				// (normal case)
				
				/*
				 *  User account activation
				 */
				 
				try {
					$sql = "SELECT hash, id
							FROM users
							WHERE hash = '".$hash."'";
					$res = $db -> query($sql);
					$userForHash = $res -> fetchAll(PDO::FETCH_ASSOC);
					$id_fromHash = $userForHash[0]['id']; // Will be used to create the picture url
					$hashMatch = count($userForHash); // Count how many matches where found
					
					if($hashMatch > 0) {
						// We have a hash match
						try {
							$sql = "SELECT hash, active
									FROM users
									WHERE hash = '".$hash."'
									AND active ='0'";
							$res = $db -> query($sql);
						}
						catch(exception $e) {
							'Erreur : '.$e -> getMessage();
						}
						$userForActivation = $res -> fetchAll(PDO::FETCH_ASSOC);
						$inactiveMatch = count($userForActivation);
						
						if($inactiveMatch > 0) {
							// Our match needs activation
							try {
								$sql = "UPDATE users
										SET active = '1'
										WHERE hash = '".$hash."'
										AND active = '0'";
								$db -> exec($sql);
							}
							catch(exception $e) {
								'Erreur : '.$e -> getMessage();
							}
							$feedback = '<p class="notice success center">Ton compte a été activé !</p>';
						}
						else {
							// User account has already been activated but hash is OK.
							$feedback = '<p class="notice info center">Ton compte est activé !</p>';
							
						}
						
						/*
						 *  Here comes the firstname and picture verification.
						 *  It doesn't matter if the user's account needs to be activated
						 *  or if it has already been activated. The requirement is that
						 *  the hash in the url matches with a user in the table.
						 */
						
						/*
						 *  User decides to set his firstname and picture
						 */
						
						if($_POST['setFirstnameAndPicture']) {
							// Form has already been displayed once
							// so we can say we have one match
							$hashMatch = 1; // Allows setFirstname to be shown more than once
							extract($_POST);
							
							if(isset($_POST['setFirstnameAndPicture'])) {
								$firstname = ucname(trim(strip_tags($firstname)));
								
								// Define error variables as NULL
								// so that they're not rendered
								// if the error is not targeted
								$errors = 0;
								$error_picture = NULL;
								$error_pictureSize = NULL;
								$error_pictureDimensionsTooSmall = NULL;
								$error_pictureDimensionsTooLarge = NULL;
								$error_pictureExtension = NULL;
								$error_noPicture = NULL;
								$error_emptyFirstname = NULL;
								$error_firstnameLength = NULL;
								
								/*
								 *  Error handling
								 */
								
								// Picture verification
								$picture = $_FILES['picture'];
								if(!empty($picture['size'])) {
									
									// Define variables for verification
									$maxSize = 51200; // 50 kb (defined in bytes)
									$minWidth = 96; // px
									$minHeight = 96; // px
									$maxWidth = 200; // px
									$maxHeight = 200; // px
									$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
									
									if($picture['error'] > 0) {
										// Error provided by the input itself
										$error_picture = 'L\'image n\'a pas pu être envoyée.';
									}
									if($picture['size'] > $maxSize) {
										// If the image uploaded exceeds the max. size
										$errors++;
										$error_pictureSize = 'L\'image renseignée est trop lourde. Son poids ne peut excéder '.$maxSize.' octets (50 ko). L\'image que tu as choisi pèse en effet '.$picture['size'].' octets.';
									}
									
									// Variables for the provided picture
									$pictureDimensions = getimagesize($picture['tmp_name']);
									$pictureWidth = $pictureDimensions[0];
									$pictureHeight = $pictureDimensions[1];
									
									if($pictureWidth < $minWidth || $pictureHeight < $minHeight) {
										// If the picture is too small
										$errors++;
										$error_pictureDimensionsTooSmall = 'Ta photo doit faire au minimum 96x96 pixels.';
									}
									
									if($pictureWidth > $maxWidth || $pictureHeight > $maxHeight) {
										// If the picture is too large
										$errors++;
										$error_pictureDimensionsTooLarge = 'Ta photo ne peut pas faire plus de 200x200 pixels.';
									}
									
									$providedExtension = strtolower(substr(strrchr($picture['name'], '.'), 1));
									if(!in_array($providedExtension, $allowedExtensions)) {
										$errors++;
										$error_pictureExtension = 'Ta photo doit être de type jpg, png, gif ou bmp pour être acceptée :(';
									}
									
								}
								else {
									// No picture provided
									$errors++;
									$error_noPicture = 'Tu n\'as pas choisi de photo.';
								}
								
								// Firstname verification
								if(empty($firstname)) {
									// Firstname field is empty
									$errors++;
									$error_emptyFirstname = 'Tu n\'as pas renseigné ton prénom.';
								}
								else {
									// Firstname field is filled
									if(strlen($firstname) > 20) {
										// Firstname is longer than 20 chars.
										$errors++;
										$error_firstnameLength = 'Ton prénom ne peut dépasser 20 caractères.';
									}
								}
								
								/*
								 *  No error found
								 *  Update the database
								 */
								
								if($errors == 0) {
									if(!empty($picture['size'])) {
										// A picture is provided
										$pictureParts = pathinfo($picture['name']); // Provides $pictureParts['extension']
										$ext = strtolower($pictureParts['extension']);
										
										// Upload the file
										move_uploaded_file($picture['tmp_name'], 'media/img/users/membre-'.$id_fromHash.'.'.$ext);
										
										// Build the url
										$pictureUrl = 'media/img/users/membre-'.$id_fromHash.'.'.$ext;
										
										
										// Update the database
										$sql = "UPDATE users
												SET picture_url = '$pictureUrl'
												WHERE id = '$id_fromHash'
												AND hash = '".$hash."'";
										try {
											$db -> exec($sql);
										}
										catch(exception $e) {
											echo 'Erreur : '.$e -> getMessage();
										}
										
										// Update the session
										$_SESSION['picture_url'] = $pictureUrl;
									}
									
									try {
										$sql = 'UPDATE users
												SET firstname = "'.$firstname.'"
												WHERE hash = "'.$hash.'"
												AND active = "1"';
										$db -> exec($sql); // Update the database
									}
									catch(exception $e) {
										echo 'erreur : '.$e->getMessage();
									}
									$_SESSION['firstname'] = $firstname; // Update the session
									redirect('index.php?page=connexion&nom='.urlencode($firstname));
								}
								else {
									// Errors found
									$feedback = '<ul class="notice error">';
									$feedback .= '<li>'.$error_picture.'</li>';
									$feedback .= '<li>'.$error_pictureSize.'</li>';
									$feedback .= '<li>'.$error_pictureDimensionsTooSmall.'</li>';
									$feedback .= '<li>'.$error_pictureDimensionsTooLarge.'</li>';
									$feedback .= '<li>'.$error_pictureExtension.'</li>';
									$feedback .= '<li>'.$error_noPicture.'</li>';
									$feedback .= '<li>'.$error_emptyFirstname.'</li>';
									$feedback .= '<li>'.$error_firstnameLength.'</li>';
									$feedback .= '</ul><!-- /.notice -->';
								}
							}
						}
						
						/*
						 *  User decides to skip this step
						 */
						
						if($_POST['later']) {
							// Prefer an empty string to a 0
							// if the page is refreshed and therefore
							// the firstname has not been set
							$firstname = '';
							$_SESSION['firstname'] = $firstname; // Update the session
							
							redirect('index.php?page=connexion');
						}
					}
					else {
						// No match: invalid url (hash doesn't match any entry in the table)
						$feedback = '<p class="notice error">Le lien n\'est pas correct.</p>';
					}
				}
				catch(exception $e) {
					echo 'erreur : '.$e->getMessage();
				}
				
			}
											
		}
	}
	else {
		// Invalid approach: no hash in the url
		$feedback = '<p class="notice error wide center">Cette URL n\'est pas valable pour activer un compte.</p>';
	}
	
?>

<header class="clearfix">
	<a href="index.php"><img id="logo" src="media/img/assets/bind-logo-knot@2x.png" alt="Bind" width="47" height="25"></a>
</header><!-- /header -->

<div class="content">
	<div class="container">
		
		<h1>Activation</h1>
		
		<?php
			echo $feedback;
		?>
		
		<?php
			// Show the form only if the user is not logged in
			if($id == 0) {
				if(isset($_GET['hash'])) {
					if($_GET['hash']) {
						if($hashMatch == 1) {
		?>
		<form class="horizontalForm compact" action="" method="post" enctype="multipart/form-data">
			<div>
				<label for="picture">Ta photo</label>
				<input type="file" name="picture" id="picture">
				<p class="helpText">Min. 96x96 pixels (idéal), max. 200x200 pixels.</p>
			</div>
			<div>
				<label for="firstname">Ton prénom</label>
				<input type="text" name="firstname" value="<?php if(isset($firstname)) echo $firstname; ?>">
			</div>
			<div class="actions">
				<input type="submit" name="setFirstnameAndPicture" class="btn btn-green" value="Enchanté !">
				<input type="submit" name="later" class="btn" value="Plus tard">
			</div><!-- /.actions -->
		</form>
		<?php
						}
					}
				}
			}
			else {
				// The user is logged in and shouldn't be here
				setError(ERR_LOGGEDIN_ACCOUNTALREADYACTIVATED);
			}
		?>
		
	</div><!-- /.container -->
</div><!-- /.content -->