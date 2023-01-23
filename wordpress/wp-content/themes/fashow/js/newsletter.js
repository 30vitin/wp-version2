/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */
( function( $ ) {
	"use strict";

// Enable menu toggle for small screens.
	$(document).ready(function() {
		$('.newsletterpopup .close-popup').on( "click", function(){
			fashow_HideNLPopup();
		});

		$('.popupshadow').on( "click", function(){
			fashow_HideNLPopup();
		});			
		
	});
	
	/* Show/hide NewsLetter Popup */
	$( window ).load(function() {
		fashow_ShowNLPopup();
	});	

		
	/* Function Show NewsLetter Popup */
	function fashow_ShowNLPopup() {
		if($('.newsletterpopup').length){
			var cookieValue = $.cookie("fashow_lpopup");
			if(cookieValue == 1) {
				$('.newsletterpopup').hide();
				$('.popupshadow').hide();
			}else{
				$('.newsletterpopup').show();
				$('.popupshadow').show();
			}				
		}
	}
	
	/* Function Hide NewsLetter Popup when click on button Close */
	function fashow_HideNLPopup(){
		$('.newsletterpopup').hide();
		$('.popupshadow').hide();
		$.cookie("fashow_lpopup", 1, { expires : 24 * 60 * 60 * 1000 });
	}
	
} )( jQuery );