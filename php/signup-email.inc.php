<?php

	$to = $email;
	$subject = 'Active ton compte Bind dès maintenant !';
	$message = 'Clique sur ce lien pour activer ton compte: http://beta.bind.stevepiron.be/index.php?page=activation&hash='.$hash;
	$headers = 'From:steve@bind.com'. "\r\n";
	mail($to, $subject, $message, $headers);
	

?>