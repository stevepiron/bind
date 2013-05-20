$(function() {

	FastClick.attach(document.body);

	var body = $('body'),
		userAccountTrigger = $('#userAccountTrigger'),
		dropdown = $('#userDropdown'),
		showMore = $('#showMore'),
		archive = $('#archive'),
		interestedUsersTrigger = $('.interest'),
		watchToggle = $('.watchToggle');
	
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
	
});