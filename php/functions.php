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
	
	function numberOfAnswers($number, $url) {
		if($number == 0) {
			return 'Pas encore de réponse';
		}
		if($number == 1) {
			return '<a href="'.$url.'">1 réponse</a>';
		}
		else {
			return '<a href="'.$url.'">'.$number.' réponses</a>';
		}
	}
	
	// Source: http://www.phpro.org/examples/URL-to-Link.html
	function clickableUrls($string){
		$string = preg_replace('/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i', '$1http://$2',$string); // Make sure there is an http:// on all Urls
		$string = preg_replace('/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i','<a target="_blank" href="$1">$1</A>',$string); // Make all Url links
		$string = preg_replace('/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i','<a href="mailto:$1">$1</a>',$string); // Make all emails hotlinks
		return $string;
	}
	
	// Source: http://cubiq.org/the-perfect-php-clean-url-generator
	setlocale(LC_ALL, 'en_US.UTF8');
	function toAscii($str, $replace=array(), $delimiter='-') {
		if(!empty($replace)) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	
	function listAllRequests($dataArray, $id) {
		$requestMarkup = '<ol class="requests">';
		foreach($dataArray as $request) {
			
			/*
			 *  Define variables
			 */
			 
			$requestState			= $request['state'];
			$requestPriority		= $request['priority'];
			$requestId				= $request['request_id'];
			$requestTitle			= $request['title'];
			$requestCategory		= htmlentities($request['category']);
			$requestYear			= $request['year'];
			$requestMessage			= $request['message'];
			$requestDate			= $request['date'];
			$requestNbAnswers		= $request['nb_answers'];
			
			$authorFirstname		= $request['firstname'];
			$authorUsefulAnswers	= $request['useful_answers'];
			$authorPictureUrl		= $request['picture_url'];	
			
			/*
			 *  Requests parts
			 */
			
			// Request start
			$requestStartUnanswered = '<li class="request unanswered">';
			$requestStartUrgent		= '<li class="request unanswered urgent">';
			$requestStartSolved		= '<li class="request solved">';
			
			// Header
			$url = 'index.php?page=question&id='.$requestId.'&q='.toAscii($requestTitle);
			$requestHeader  = '<header>';
			$label = '<a class="label" href="#">'.$requestYear.' - '.$requestCategory.'</a>';
			$requestHeader .= '<h2><a class="title" href="'.$url.'">'.$requestTitle.'</a> '.$label.'</h2>'; // Request title and category
			$requestHeader .= '</header>';
			
			// Aside: author info
			$requestAside  = '<aside><ul>';
			$requestAside .= '<li class="author"><img src="'.$authorPictureUrl.'" alt="Photo de '.$authorFirstname.'" width="48" height="48"> '.$authorFirstname.'</li>'; // Author picture and name
			$requestAside .= '<li class="bestAnswersCount" title="'.$authorUsefulAnswers.' réponses utiles">'.$authorUsefulAnswers.'</li>'; // Number of best answers
			$requestAside .= '<li class="publishedDate">'.daysSincePost($requestDate).'</li>'; // Date
			$requestAside .= '</ul></aside>';
			
			// Article: the request itself
			$requestArticle  = '<article>';
			$requestArticle .= $requestMessage; 
			
				// Footer if logged in
				$urlAnswers = $url.'#interactions';
				$urlForm = $url.'#commentForm';
				$requestFooterLoggedIn  = '<footer>';
				if($requestState == 0) {
					// Logged in and unsolved
					$requestFooterLoggedIn .= '<p class="requestStats">'.numberOfAnswers($requestNbAnswers, $urlAnswers).' • <span class="interest" href="#">2 intéressés</span></p>';
					$requestFooterLoggedIn .= '<div class="interestedUsersFaces">';
						// ...the pictures of the interested users
					$requestFooterLoggedIn .= '</div><!-- /.interestedUserfaces -->';
					if($requestPriority == 0) {
						// Normal request: green button
						$requestFooterLoggedIn .= '<a class="btn btn-green" href="'.$urlForm.'">Répondre</a>';
					}
					else {
						// Urgent request: red button
						$requestFooterLoggedIn .= '<a class="btn btn-red" href="'.$urlForm.'">Répondre</a>';
					}
					$requestFooterLoggedIn .= '<a class="btn btn-link watchToggle" href="#">Surveiller</a>';
				}
				else {
					// Logged in and solved
					$requestFooterLoggedIn .= '<p class="requestStats">'.numberOfAnswers($requestNbAnswers, $urlAnswers).'</p>';
				}
				$requestFooterLoggedIn .= '</footer></article>';
				
				// Footer if not logged in
				$requestFooterNotLoggedIn  = '<footer>';
				$requestFooterNotLoggedIn .= '<p class="answers" href="#">'.numberOfAnswers($requestNbAnswers, $urlAnswers).'</a>';
				$requestFooterNotLoggedIn .= '</footer></article>';
			
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
				// Request is solved
				$requestMarkup .= $requestStartSolved;
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
		}
		$requestMarkup .= '</ol><!-- /.requests -->';
		return $requestMarkup;
	}
	
	function singleRequest($dataArray, $id) {
		$requestMarkup = '';
		foreach($dataArray as $request) {
			
			/*
			 *  Define variables
			 */
			 
			$requestState			= $request['state'];
			$requestPriority		= $request['priority'];
			$requestId				= $request['request_id'];
			$requestTitle			= $request['title'];
			$requestCategory		= htmlentities($request['category']);
			$requestYear			= $request['year'];
			$requestMessage			= $request['message'];
			$requestDate			= $request['date'];
			$requestNbAnswers		= $request['nb_answers'];
			
			$authorFirstname		= $request['firstname'];
			$authorUsefulAnswers	= $request['useful_answers'];
			$authorPictureUrl		= $request['picture_url'];	
			
			/*
			 *  Requests parts
			 */
			
			// Request start
			$requestStartUnanswered = '<section class="request unanswered">';
			$requestStartUrgent		= '<section class="request unanswered urgent">';
			$requestStartSolved		= '<section class="request solved">';
			
			// Header
			$url = 'index.php?page=question&id='.$requestId.'&q='.toAscii($requestTitle);
			$requestHeader  = '<header>';
			$label = '<a class="label" href="#">'.$requestYear.' - '.$requestCategory.'</a>';
			$requestHeader .= '<h2><a class="title"href="'.$url.'">'.$requestTitle.'</a> '.$label.'</h2>'; // Request title and category
			$requestHeader .= '</header>';
			
			// Aside: author info
			$requestAside  = '<aside><ul>';
			$requestAside .= '<li class="author"><img src="'.$authorPictureUrl.'" alt="Photo de '.$authorFirstname.'" width="48" height="48"> '.$authorFirstname.'</li>'; // Author picture and name
			$requestAside .= '<li class="bestAnswersCount" title="'.$authorUsefulAnswers.' réponses utiles">'.$authorUsefulAnswers.'</li>'; // Number of best answers
			$requestAside .= '<li class="publishedDate">'.daysSincePost($requestDate).'</li>'; // Date
			$requestAside .= '</ul></aside>';
			
			// Article: the request itself
			$requestArticle  = '<article>';
			$requestArticle .= html_entity_decode(($requestMessage), ENT_QUOTES, 'UTF-8');
			
				// Footer if logged in
				$urlAnswers = $url.'#interactions';
				$requestFooterLoggedIn  = '<footer>';
				if($requestState == 0) {
					// Logged in and unsolved
					$requestFooterLoggedIn .= '<p class="requestStats">'.numberOfAnswers($requestNbAnswers, $urlAnswers).' • <a class="interest" href="#"> intéressé</a></p>';
					$requestFooterLoggedIn .= '<div class="interestedUsersFaces">';
						// ...the pictures of the interested users
					$requestFooterLoggedIn .= '</div><!-- /.interestedUserfaces -->';

					$requestFooterLoggedIn .= '<a class="btn btn-link watchToggle" href="#">Surveiller</a>';
				}
				else {
					// Logged in and solved
					$requestFooterLoggedIn .= '<p class="requestStats">'.numberOfAnswers($requestNbAnswers, $urlAnswers).'</p>';
				}
				$requestFooterLoggedIn .= '</footer></article>';
				
				// Footer if not logged in
				$requestFooterNotLoggedIn  = '<footer>';
				$requestFooterNotLoggedIn .= '<p class="answers" href="#">'.numberOfAnswers($requestNbAnswers, $urlAnswers).'</a>';
				$requestFooterNotLoggedIn .= '</footer></article>';
			
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
				// Request is solved
				$requestMarkup .= $requestStartSolved;
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
		}
		$requestMarkup .= '</section><!-- /.request -->';
		return $requestMarkup;
	}
	
	function answersThread($dataArray, $id) {
		$answerMarkup  = '<section id="interactions">';
		$answerMarkup .= '<ol class="comments">';
		foreach($dataArray as $answer) {
			
			/*
			 *  Define variables
			 */
			 
			$answerId				= $answer['answer_id'];
			$answerAuthor			= $answer['author'];
			$answerMessage			= $answer['message'];
			$answerDate				= $answer['date'];
			$answerValue			= $answer['value'];
			
			$authorFirstname		= $answer['firstname'];
			$authorUsefulAnswers	= $answer['useful_answers'];
			$authorPictureUrl		= $answer['picture_url'];
			
			$request				= $answer['fk_request'];
			
			/*
			 *  Answer parts
			 */
			
			$answerStartNormal	= '<li>';
			$answerStartBest	= '<li class="bestAnswer">';
			
			// Aside: author info
			$answerAside  = '<aside>';
			$answerAside .= '<img src="'.$authorPictureUrl.'" alt="Photo de '.$authorFirstname.'" width="48" height="48">';
			$answerAside .= '</aside>';
			
			// Article: the answer itself
			$answerArticle  = '<article>';
			$answerArticle .= '<header>';
			$answerArticle .= '<p class="author">'.$requestAuthor.$authorFirstname.' <span class="bestAnswersCount" title="'.$authorUsefulAnswers.' réponses utiles">'.$authorUsefulAnswers.'</span></p>';
			$answerArticle .= '</header>';
			$answerArticle .= html_entity_decode($answerMessage, ENT_QUOTES, 'UTF-8').'</p>';
			$answerArticle .= '<footer>';
			$answerArticle .= '<span class="publishedDate">'.daysSincePost($answerDate).'</span>';
			$answerArticle .= '<button class="voteBest btn btn-small btn-link" data-id="'.$answerId.'" data-request="'.$request.'">Définir comme meilleure réponse</button>';
			$answerArticle .= '</footer>';
			$answerArticle .= '</article>';
			
			// Answer end
			$answerEnd = '</li>';
			
			/*
			 *  Build the answer
			 */
			
			$answerMarkup  .= $answerStart;
			if($answerValue == 0) {
				// Normal answer
				$answerMarkup .= $answerStartNormal;
			}
			else {
				// Best answer
				$answerMarkup  .= $answerStartBest;
			}
			$answerMarkup .= $answerAside;
			$answerMarkup .= $answerArticle;
			$answerMarkup .= $answerEnd;
		}
		$answerMarkup .= '</ol><!-- /.comments -->';
		$answerMarkup .= '</section><!-- /#interactions -->';
		return $answerMarkup;
	}
	
	function listCategories($dataArray) {
		$categoriesOptions  = '';
		$i = 0;
		foreach($dataArray as $category) {
		
			/*
			 *  Define variables
			 */
			
			$categoryId		= $category['id'];
			$categoryName	= htmlentities($category['category']);
			
			if($i == 0) {
				$categoriesOptions .= '<option value="'.$categoryId.'" selected>'.$categoryName.'</option>';
			}
			else {
				$categoriesOptions .= '<option value="'.$categoryId.'">'.$categoryName.'</option>';	
			}
			$i = 1;
		}
		return $categoriesOptions;
	}

?>