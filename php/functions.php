<?php
	
	// Source: http://www.php.net/manual/fr/function.ucwords.php#96179
	function ucname($string) {
	    $string =ucwords(strtolower($string));
	
	    foreach (array('-', '\'') as $delimiter) {
	      if (strpos($string, $delimiter)!==false) {
	        $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
	      }
	    }
	    return $string;
	}
	
	function setError($error = '') {
		$msg = ($error != '') ? $error : 'Une erreur inconnue s\'est produite.';
		echo '<p class="notice error wide center">'.$msg.'</p>';
	}
	
	function redirect($page){
		header('Location: '.$page);
	}
	
	function listAllRequests($dataArray) {
		$requestMarkup = '<ol class="requests">';
			foreach($dataArray as $request) {
			
			
			// Define variables
			$requestState		= $request['state'];
			$requestPriority	= $request['priority'];
			$requestTitle		= htmlentities($request['title']);
			$requestCategory	= htmlentities($request['category']);
			$requestMessage		= htmlentities($request['message']);
			
			/*
			 *  State check:
			 *  Is the request answered or not?
			 */
			
			if($requestState == 0) {
				// Request is unanswered
				
				/*
				 *  Priority check:
				 *  Is the request urgent or not?
				 */
				
				if($requestPriority == 0) {
					// Default priority
					$requestMarkup .= '<li class="request unanswered">'; 
				}
				else {
					// Urgent request
					$requestMarkup .= '<li class="request unanswered urgent">';
				}
			}
			else {
				// Request is answered
				$requestMarkup .= '<li class="request solved">';
			}
			
			// Header
			$requestMarkup .= '<header>';
			$requestMarkup .= '<h2><a href="#">'.$requestTitle.'</a> <a class="label" href="#">'.$requestCategory.'</a></h2>'; // Request title and category
			$requestMarkup .= '</header>';
			
			// Aside: author info
			$requestMarkup .= '<aside><ul>';
			$requestMarkup .= '<li class="author"><img src="" alt="" width="48" height="48"> </li>'; // Author picture and name
			$requestMarkup .= '<li class="bestAnswersCount" title=" réponses utiles"></li>'; // Number of best answers
			$requestMarkup .= '<li class="publishedDate">Il y a x jours</li>'; // Date
			$requestMarkup .= '</ul></aside>';
			
			// Article: the request itself
			$requestMarkup .= '<article>';
			$requestMarkup .= $requestMessage;
			$requestMarkup .= '</article>';
			
			$requestMarkup .= '</li>';
		}
		$requestMarkup .= '</ol><!-- /.requests -->';
		return $requestMarkup;
	}

?>