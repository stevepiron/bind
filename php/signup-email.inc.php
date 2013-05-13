<?php

	$to = $email;
	$subject = 'Confirme ton compte Bind !';
	$message = 'Clique sur ce lien pour activer ton compte: http://bind.stevepiron.be/index.php?page=activation&email='.urlencode($email).'&hash='.$hash;
	$headers = 'From:steve@bind.com'. "\r\n";
	mail($to, $subject, $message, $headers);
	

?>