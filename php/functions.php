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
	
	function numberOfAnswers($number) {
		if($number == 1) {
			return '1 réponse';
		}
		else {
			return $number.' réponses';
		}
	}
	
	// Source: http://www.phpro.org/examples/URL-to-Link.html
	function clickableUrls($string){
		$string = preg_replace('/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i', '$1http://$2',$string); // Make sure there is an http:// on all Urls
		$string = preg_replace('/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i','<a target="_blank" href="$1">$1</A>',$string); // Make all Url links
		$string = preg_replace('/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i','<a href="mailto:$1">$1</a>',$string); // Make all emails hotlinks
		return $string;
	}
	
	function listAllRequests($dataArray, $id) {
		$requestMarkup = '<ol class="requests">';
		foreach($dataArray as $request) {
			
			/*
			 *  Define variables
			 */
			 
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
			 *  Requests parts
			 */
			
			// Request start
			$requestStartUnanswered = '<li class="request unanswered">';
			$requestStartUrgent		= '<li class="request unanswered urgent">';
			$requestStartAnswered	= '<li class="request solved">';
			
			// Header
			$requestHeader  = '<header>';
			$requestHeader .= '<h2><a href="#">'.$requestTitle.'</a> <a class="label" href="#">'.$requestCategory.'</a></h2>'; // Request title and category
			$requestHeader .= '</header>';
			
			// Aside: author info
			$requestAside  = '<aside><ul>';
			$requestAside .= '<li class="author"><img src="'.$authorPictureUrl.'" alt="Photo de '.$authorFirstname.'" width="48" height="48"> '.$authorFirstname.'</li>'; // Author picture and name
			$requestAside .= '<li class="bestAnswersCount" title="'.$authorUsefulAnswers.' réponses utiles">'.$authorUsefulAnswers.'</li>'; // Number of best answers
			$requestAside .= '<li class="publishedDate">'.daysSincePost($requestDate).'</li>'; // Date
			$requestAside .= '</ul></aside>';
			
			// Article: the request itself
			$requestArticle  = '<article>';
			$requestArticle .= '<p>'.clickableUrls($requestMessage).'</p>';
			
				// Footer if logged in
				$requestFooterLoggedIn  = '<footer>';
				$requestFooterLoggedIn .= '<a class="btn" href="#">Répondre</a>';
				$requestFooterLoggedIn .= '<a class="btn btn-link watchToggle" href="#">Surveiller cette question</a>';
				$requestFooterLoggedIn .= '<p class="answers" href="#"></a> • <a class="interest" href="#"> intéressé</a></p>';
				$requestFooterLoggedIn .= '<div class="interestedUsersFaces">';
					// ...the pictures of the interested users
				$requestFooterLoggedIn .= '</div><!-- /.interestedUserfaces -->';
				$requestFooterLoggedIn .= '</footer></article>';
				
				// Footer if not logged in
				$requestFooterNotLoggedIn  = '<footer>';
				$requestFooterNotLoggedIn .= '<p class="answers" href="#">x réponses</a>';
				$requestFooterNotLoggedIn .= '</footer></article>';
			
			// Request end	
			$requestEnd  = '</li>';
			$requestEnd .= '</article>';
			
			/*
			 *  Build the request
			 */
			
			if($requestState == 0) {
				// Request is unanswered
				
				/*
				 *  Priority check:
				 *  Is the request urgent or not?
				 */
				
				if($requestPriority == 0) {
					// Default priority
					$requestMarkup .= $requestStartUnanswered;
				}
				else {
					// Urgent request
					$requestMarkup .= $requestStartUrgent;
				}
			}
			else {
				// Request is answered
				$requestMarkup .= $requestStartAnswered;
			}
			
			$requestMarkup .= $requestHeader;
			$requestMarkup .= $requestAside;
			$requestMarkup .= $requestArticle;
			if($id == 0) {
				$requestMarkup .= $requestFooterNotLoggedIn;
			}
			else {
				$requestMarkup .= $requestFooterLoggedIn;
			}
			$requestMarkup .= $requestEnd;
		}
		$requestMarkup .= '</ol><!-- /.requests -->';
		return $requestMarkup;
	}

?>