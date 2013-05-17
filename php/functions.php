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
	
	// Source: http://stackoverflow.com/a/2040589
	function daysSincePost($date) {
		$now = time();
		$dateOfPost = strtotime($date);
		$dateDiff = $now - $dateOfPost;
		$days = floor($dateDiff/(60*60*24));
		
		if($days == 0) {
			return 'Aujourd\'hui';
		}
		elseif($days == 1) {
			return 'Hier';
		}
		else {
			return 'Il y a '.$days.' jours';
		}
	}
	
	// Source: http://www.phpro.org/examples/URL-to-Link.html
	function clickableUrls($string){
		$string = preg_replace('/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i', '$1http://$2',$string); // Make sure there is an http:// on all Urls
		$string = preg_replace('/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i','<a target="_blank" href="$1">$1</A>',$string); // Make all Url links
		$string = preg_replace('/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i','<a href="mailto:$1">$1</a>',$string); // Make all emails hotlinks
		return $string;
	}
	
	function listAllRequests($dataArray) {
		$requestMarkup = '<ol class="requests">';
			foreach($dataArray as $request) {
			
			
			// Define variables
			$requestState			= $request['state'];
			$requestPriority		= $request['priority'];
			$requestTitle			= htmlentities($request['title']);
			$requestCategory		= htmlentities($request['category']);
			$requestMessage			= htmlentities($request['message']);
			$requestDate			= $request['date'];
			
			$authorFirstname		= $request['firstname'];
			$authorUsefulAnswers	= $request['useful_answers'];
			$authorPictureUrl		= $request['picture_url'];	
			
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
			$requestMarkup .= '<li class="author"><img src="'.$authorPictureUrl.'" alt="Photo de '.$authorFirstname.'" width="48" height="48"> '.$authorFirstname.'</li>'; // Author picture and name
			$requestMarkup .= '<li class="bestAnswersCount" title="'.$authorUsefulAnswers.' réponses utiles">'.$authorUsefulAnswers.'</li>'; // Number of best answers
			$requestMarkup .= '<li class="publishedDate">'.daysSincePost($requestDate).'</li>'; // Date
			$requestMarkup .= '</ul></aside>';
			
			// Article: the request itself
			$requestMarkup .= '<article>';
			$requestMarkup .= clickableUrls($requestMessage);
			$requestMarkup .= '</article>';
			
			$requestMarkup .= '</li>';
		}
		$requestMarkup .= '</ol><!-- /.requests -->';
		return $requestMarkup;
	}

?>