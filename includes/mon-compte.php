<?php
	$__TITLE_PAGE__ = 'Mon compte • Bind';
	$__DESC_PAGE__ = '';
	$section = 'mon-compte';
	$level = '1';
	
	session_start();
	
	// Session variables
	$id = (isset($_SESSION['id'])) ? (int) $_SESSION['id'] : 0;
	$firstname = (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '';
	
	// Includes
	require_once 'php/functions.php';
	require_once 'php/constants.php';
	
	// Form is sent
	if(isset($_POST['editAccount'])) {
		// Define variables
		// (replace session data with posted data)
		extract($_POST);
		
		if($_POST['editAccount']) {
			// Define error variables as NULL
			// so that they're not rendered
			// if the error is not targeted
			$errors = 0;
			$error_emptyFirstname = NULL;
			$error_firstnameLength = NULL;
			$error_email = NULL;
			$error_emailAlreadyUsed = NULL;
			$error_emptyConfirm  = NULL;
			$error_passwordsDontMatch = NULL;
			$error_picture = NULL;
			$error_pictureSize = NULL;
			$error_pictureDimensionsTooLarge = NULL;
			$error_pictureExtension = NULL;
			
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
			
			// Firstname verification
			if(empty($firstname)) {
				$errors++;
				$error_emptyFirstname = 'Hé là-bas, pas trop vite ! C\'est quoi ton prénom ?';
			}
			else {
				// Firstname field is filled
				if(strlen($firstname) > 20) {
					// Firstname is longer than 20 chars.
					$errors++;
					$error_firstnameLength = 'Ton prénom ne peut dépasser 20 caractères.';
				}
			}
			
			// Email address verification
			$sql = "SELECT id, email
					FROM users
					WHERE email = '$email'
					AND id <> '$id'"; // id ≠ $id
			try {
				$res = $db -> query($sql); // Find if there is another user already using this email address
				$count = $res -> fetchAll(PDO::FETCH_ASSOC);
			}
			catch(exception $e) {
				echo 'Erreur : '.$e -> getMessage();
			}
			if(empty($count)) {
				// No user other than you uses this email address
				if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors++;
					$error_email = 'Tu dois impérativement mentionner une adresse email valide.';
				}
			}
			else {
				// Someone other than you already uses this email address
				$errors++;
				$error_emailAlreadyUsed = 'Cette adresse email est déjà associée à un compte.';
			}
			
			// Password verification
			if(!empty($newPassword)) {
				if(empty($newPasswordConfirm)) {
					// Empty confirmation
					$errors++;
					$error_emptyConfirm = 'Le nouveau mot de passe doit être confirmé dans le champ adéquat.';
				}
				if($newPasswordConfirm !== $newPassword) {
					// Password and confirmation don't match
					$errors++;
					$error_passwordsDontMatch = 'Le nouveau mot de passe et sa confirmation ne correspondent pas.';
				}
				else {
					// Password and confirmation match
					$newPassword = md5($newPassword);
					$newPasswordConfirm = md5($newPasswordConfirm);
				}
			}
			
			/*
			 *  No error found
			 *  Update the database
			 */
			
			if($errors == 0) {
				if(!empty($picture['size'])) {
					// If a new picture is provided
					$pictureParts = pathinfo($picture['name']); // Provides $pictureParts['extension']
					$ext = strtolower($pictureParts['extension']);
					
					// Upload the file
					move_uploaded_file($picture['tmp_name'], 'media/img/users/membre-'.$id.'.'.$ext);
					
					// Build the url
					$pictureUrl = 'media/img/users/membre-'.$id.'.'.$ext;
					
					
					// Update the database
					$sql = "UPDATE users
							SET picture_url = '$pictureUrl'
							WHERE id = '$id'";
					try {
						$db -> exec($sql);
					}
					catch(exception $e) {
						echo 'Erreur : '.$e -> getMessage();
					}
					
					// Update the session
					$_SESSION['picture_url'] = $pictureUrl;
				}
				
				// Prepare variables
				$email = strtolower(trim(strip_tags($email)));
				$firstname = ucname(trim(strip_tags($firstname)));
								
				if(!empty($newPassword)) {
					// Update data with new password
					$sql = "UPDATE users
							SET firstname = '$firstname',
								email = '$email',
								password = '$newPassword'
							WHERE id = '$id'";
				}
				else {
					// Update data without password change
					$sql = "UPDATE users
							SET firstname = '$firstname',
								email = '$email'
							WHERE id = '$id'";
				}
				try {
					// Update database
					$res = $db -> exec($sql);
					
					// Update Session
					$_SESSION['firstname'] = $firstname;
					$_SESSION['email'] = $email;
				}
				catch(exception $e) {
					echo 'Erreur : '.$e -> getMessage();
				}
				$feedback = '<p class="notice success">Tes informations ont été mises à jour avec succès ! :)</p>';
			}
			// Errors found
			else {
				$feedback = '<ul class="notice error">';
				$feedback .= '<li>'.$error_emptyFirstname.'</li>';
				$feedback .= '<li>'.$error_firstnameLength.'</li>';
				$feedback .= '<li>'.$error_email.'</li>';
				$feedback .= '<li>'.$error_emailAlreadyUsed.'</li>';
				$feedback .= '<li>'.$error_emptyConfirm.'</li>';
				$feedback .= '<li>'.$error_passwordsDontMatch.'</li>';
				$feedback .= '<li>'.$error_picture.'</li>';
				$feedback .= '<li>'.$error_pictureSize.'</li>';
				$feedback .= '<li>'.$error_pictureDimensionsTooLarge.'</li>';
				$feedback .= '<li>'.$error_pictureExtension.'</li>';
				$feedback .= '</ul><!-- /.notice -->';
			}
			
		}
	}
	
?>

<div class="content">
	<div class="container">
		
		<header role="page-header">
			<div>
				<h1>Gérer mon compte</h1>
			</div>
		</header>
		
		<?php
			if(isset($feedback)) {
				echo $feedback;
			}
			
			if($id == 0) {
				setError(ERR_NOTLOGGEDIN); // If the user is not logged in
			}
			else {
		?>
		
		<form class="horizontalForm" id="editAccount" action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<h3>Informations publiques</h3>
				<div>
					<label for="picture">Ta photo</label>
					<img class="picturePreview rounded" src="<?php echo $dig; ?><?php if(isset($picture_url)) echo $picture_url; ?>" class="rounded" alt="<?php if(isset($firstname)) echo 'Ma photo ('.$firstname.')'; ?>" width="48" height="48">
					<input type="file" name="picture" id="picture">
					<p class="helpText">Min. 96x96 pixels (idéal), max. 200x200 pixels.</p>
				</div>
				<div>
					<label for="firstname">Ton prénom</label>
					<input type="text" name="firstname" id="firstname" value="<?php if(isset($firstname)) echo $firstname; ?>">
				</div>
			</fieldset>
			<fieldset>
				<h3>Informations confidentielles</h3>
				<div>
					<label for="email">Ton email</label>
					<input type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>">
					<p class="helpText">Ton email te sert d'identifiant de connexion.</p>
				</div>
				<div>
					<label for="newPassword">Un nouveau mot de passe ?</label>
					<input type="password" name="newPassword" id="newPassword">
					<p class="helpText">Pas obligatoire ! :)</p>
				</div>
				<div>
					<label for="newPasswordConfirm">Confirme ton nouveau mot de passe</label>
					<input type="password" name="newPasswordConfirm" id="newPasswordConfirm">
					<p class="helpText">Seulement si tu veux changer ton mot de passe.</p>
				</div>
				<div>
					<p class="helpText"><a id="deleteAccount" href="#">Supprimer ton compte</a></p>
				</div>
			</fieldset>
			<div class="actions">
				<input type="submit" name="editAccount" class="btn btn-green" value="Enregistrer">
			</div><!-- /.actions -->
		</form>
		
		
		
		<?php } ?>
		
	</div><!-- /.container -->
</div><!-- /.content -->