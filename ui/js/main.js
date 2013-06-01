$(function() {

	FastClick.attach(document.body);

	var body = $('body'),
		userAccountTrigger = $('#userAccountTrigger'),
		dropdown = $('#userDropdown'),
		showMore = $('#showMore'),
		archive = $('#archive'),
		interestedUsersTrigger = $('.interest'),
		watchToggle = $('.watchToggle'),
		vote = $('.voteBest');
	
	/*
	 * Functions
	 */
	
	function showDropdown() {
		userAccountTrigger.addClass('active');
		dropdown.removeClass('hidden');
	}
	
	function hideDropdown() {
		userAccountTrigger.removeClass('active');
		dropdown.addClass('hidden');
	}
	
	/*
	 * Show or hide user menu
	 */
	
	body.click(function() {
		if(userAccountTrigger.hasClass('active')) {
			hideDropdown();
		}
	});
	
	userAccountTrigger.click(function(e) {
		if(userAccountTrigger.hasClass('active')) {
			hideDropdown();
		}
		else {
			showDropdown();
		}
		e.stopPropagation();
	});
	
	/*
	 * Show more requests
	 */
	
	showMore.click(function(e) {
		$(this).remove();
		archive.show();
		e.preventDefault();
	});
	
	/*
	 * Toggle interested students
	 */
	
	interestedUsersTrigger.click(function(e) {
		var interestedUsersFaces = $(this).parent().siblings('.interestedUsersFaces');
		interestedUsersFaces.slideToggle(180);
		e.preventDefault();
	});
	
	/*
	 * Toggle watch state
	 */
	
	watchToggle.click(function(e) {
		$(this).toggleClass('watching');
		e.preventDefault();
	});
	
	/*
	 * Vote for the best answer
	 */
	
	vote.click(function() {
		// Get data attributes from the button
		var $this = $(this),
			id = $this.data('id'),
			request = $this.data('request'),
			li = $this.parent().parent().parent(),
			liSiblings = li.siblings();
		
		// Vote for this answer
		voteBest(id, request, li, liSiblings);
		
		liSiblings.removeClass('bestAnswer');
		li.addClass('bestAnswer');
		
	});
	
	var xmlHttp;
	
	function voteBest(answerId, requestId) {
		
		xmlHttp = GetXmlHttpObject();
		if(xmlHttp == null) {
			console.log('Browser does not support HTTP Request.');
			return;
		}
		else {
			var url = 'php/vote.php';
			url += '?id='+answerId;
			url += '&r='+requestId;
			
			xmlHttp.onreadystatechange = stateChanged;
			xmlHttp.open('GET', url, true);
			xmlHttp.send(null);
			
			return true;
		}
	}
	
	function stateChanged() {
		if(xmlHttp.readyState == 4 || xmlHttp.readyState == 'complete') {
			// On ajoute la classe à la meilleure réponse
			console.log(xmlHttp.responseText);
		}
	}
	
	function GetXmlHttpObject() {
		var xmlHttp = null;
		try {
			// Firefox, Opera 8.0+, Safari
			xmlHttp = new XMLHttpRequest();
		}
		catch(e) {
			// Internet Explorer
			try {
				xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
			}
			catch(e) {
				xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
		}
		return xmlHttp;
	}
	
});