/*
window.onload = function() {
  var grid = new Masonry( document.getElementsByClassName('requests')[0], {
    columnWidth: 330,
    isFitWidth: true
  });
};
*/

$(function() {

	$('body').polypage();

	var body = $('body'),
		userAccountTrigger = $('#userAccountTrigger'),
		dropdown = $('#userDropdown'),
		watch = $('.watch'),
		dismiss = $('.dismiss'),
		showArchive = $('#showArchive'),
		hideArchive = $('#hideArchive'),
		archive = $('#archive');
	
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
	 * Toggle "watch" button
	 */
	
	watch.click(function(e) {
		var $this = $(this);
		
		if(!$this.hasClass('active')) {
			$this.addClass('active');
		}
		else {
			$this.removeClass('active');
		}
		e.preventDefault();
		e.stopPropagation();
	});
	
	/*
	 * Dismiss request
	 */
	
	dismiss.click(function(e) {
		$(this).parent().parent().remove();
		e.preventDefault();
	});
	
	/*
	 * Show or hide archive
	 */
	
	showArchive.click(function(e) {
		$(this).hide();
		archive.show();
		e.preventDefault();
	});
	
	hideArchive.click(function(e) {
		showArchive.show();
		archive.hide();
		e.preventDefault();
	});
	
});