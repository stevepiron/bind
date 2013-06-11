<?php

	$to = $email;
	$subject = 'Active ton compte Bind dès maintenant !';
	
	$message  = '<html><body>';
	$message .= '<p>Salut et bienvenue sur Bind !</p>';
	$message .= '<p>Bind te permet d\'entrer et rester en contact avec tous les étudiants de ton école.</p>';
	$message .= '<p>Maintenant que tu fais partie de la famille, tu peux dès à présent adresser une question qui sera transmise à une incroyable quantité de matière grise !</p>';
	$message .= '<p>Si tu as un peu de temps libre, reviens nous voir et partage ton savoir, il y a de fortes chances que celui-ci te rapporte de précieux points pour lesquels tes potes se battent déjà ;)</p>';
	$message .= '<p>En voiture Simone ! <a href="http://bind.stevepiron.be/index.php?page=activation&hash='.$hash.'">Active ton compte</a> tant qu\'il est encore chaud !</p>';
	$message .= '</body></html>';
	
	$headers  = 'From:steve@bind.com'."\r\n";
	$headers .= 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-Type: text/html; charset=utf-8'."\r\n";
	mail($to, $subject, $message, $headers);
	

?>