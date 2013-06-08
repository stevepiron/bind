$(function() {
	/*
	 * Fastclick
	 */
	
	FastClick.attach(document.body);
	
	/*
	 * WYSIHTML5
	 */
	
	var editor = new wysihtml5.Editor("wysihtml5-textarea", { // id of textarea element
		toolbar: "wysihtml5-toolbar", // id of toolbar element
		parserRules: wysihtml5ParserRules, // defined in parser rules set
		useLineBreaks: false // By default wysihtml5 will insert a <br> for line breaks, set this to false to use <p>
	});
	
	/*
	 * Global variables
	 */
	
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
	
	/*
	 *  Styled select (by @Cryde_)
	 */
	
	$('.styled-select').each(function(i, elem) {
		/* On crée une fausse liste d'éléments */
		var firstElem = '',
			$this = $(this);
		$this.children('option').each(function(i, elem){
	
			if($(elem).attr('selected') == 'selected') firstElem = $(elem).text();
			//var background = $(elem).attr('data-img');
			//img = (typeof background != 'undefined')? '<img src="'+background+'" />' : '';
			$(this).parent().siblings().children('.contVal').append($('<li>' + '<span>' +$(elem).text() + '</span></li>').data('value', $(elem).val()));
		});
	
		$this.siblings().children('.valSelect').text(firstElem);
	});
	
	var allContVals = $('.contVal');
	
	/* Lorsqu'on clique */
	$('.valSelect, .arrowSelect').click(function(e){
		var $this = $(this),
			relatedContVal = $(this).siblings('.contVal');
		
		/* If we want only one dropdown to be visible at a time */
		allContVals.hide();
		if(!relatedContVal.hasClass('shown')) {
			relatedContVal.addClass('shown').show();
			// Styling
			$this.addClass('active');
			$this.siblings('span').addClass('active');
		}
		else {
			relatedContVal.removeClass('shown').hide();
			// Styling
			$this.removeClass('active');
			$this.siblings('span').removeClass('active');
		}
		
		/* If we want to keep the dropdowns open */
		// relatedContVal.toggle();
		
		e.stopPropagation();
	});

	/* On a choisi un élement */
	$('.contVal li').click(function(){

		$('select option[selected="selected"]').removeAttr('selected');
		$('.contVal').hide();
		
		var text = $(this).text(),
			val = $(this).data('value');

		$(this).parent()
			.removeClass('shown')
			.siblings('.valSelect')
				.text(text)
				.removeClass('active')
			.siblings('.arrowSelect')
				.removeClass('active');
		$('select option[value="'+val+'"]').attr('selected', 'selected').change();
	});


	/* Si on clique autre part */
	$('html').click(function(){
		if($('.contVal').is(':visible')) $('.contVal').hide();
		if($('.contVal').hasClass('shown')) $('.contVal').removeClass('shown');
		if($('.valSelect').hasClass('active')) $('.valSelect').removeClass('active');
		if($('.arrowSelect').hasClass('active')) $('.arrowSelect').removeClass('active');
	});
	
});