/* 	============================================================================
	sales++ jQuery Plugins, http://www.salesplusplus.com
	----------------------------------------------------------------------------	
	Plugin: validateMyForm
	Version: 1.0
	Description: This file is contains the style definitions for the jQuery plugin 
	File: jquery.validateMyForm.1.0.js
	License: MIT, see http://jquery.org/license
	Author: Andy Shora, andy@puremodules.com, Copyright 2010 Andy Shora
	============================================================================
*/
(function($) {
  $.fn.validateMyForm = function(options) {
	/* set default options */
    var options = $.extend({
			form: '#form1',
			requiredClass: 'required',
			message: "Please complete all required fields",
			showMessage: false,
			showNotifications: true,
			notificationText: 'required',
			notificationClass: 'required-display',
			emailValidationClass: 'email',
			numericValidationClass: 'numeric',
			ifClass: 'if', /* if inputs with this class (appended by an integer, e.g. if2) are not null */
			thenClass: 'then', /* then validate inputs with this class (appended by the same integer, e.g. then2) */
			shake: true,
			scrollUp: true
    }, options);
	/* iterate over the matched elements passed to the plugin */
  $(this).each(function() {
		/* main plugin code goes here */
		
		//attach this validator to the form's submit event
		$(options.form).bind('submit', function(){
				var invalidFields = 0;
				var firstInvalidField = "";
				//loop through basic validation class, check all these required fields are not empty
				$("."+options.requiredClass).each(function(){
					if ( $(this).val() == "" ) {
						if (options.showNotifications) showNotification( $(this), options.shake );
						if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
						invalidFields++;
						
					} else {
						//check for custom validation, in this case input cannot be empty AND has to pass custom validation
						if (( $(this).hasClass( options.emailValidationClass ) ) && ( !(isValidEmail( $(this).val() ) ))) {
								showCustomNotification( $(this), 'invalid email', options.shake );
								if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
								invalidFields++;
						} else if (( $(this).hasClass( options.numericValidationClass ) ) && ( !(isNumeric( $(this).val() ) ))){
								showCustomNotification( $(this), 'not numeric', options.shake );
								if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
								invalidFields++;
						} else if (options.showNotifications) {
								hideNotification( $(this) );
						}
					}
				});
				//loop through conditional validation class, if primary input is not null, then validate secondary input
				var conditionalLoop = 1;
				
				var debug = $("." + options.ifClass + conditionalLoop).length;
				//alert("debug:"+debug);
				
				while ( $("." + options.ifClass + conditionalLoop).length > 0 ){
				
					// if primary imput is not null
					if ( $("." + options.ifClass + conditionalLoop).val() != "" ) {
						//validate secondary inputs

						$("." + options.thenClass + conditionalLoop).each(function(){
								//alert("debug:"+$(this).val());
								if ( $(this).val() == "" ) {
									if (options.showNotifications) showNotification( $(this), options.shake );
									if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
									invalidFields++;
								} else {
									//check for custom validation, in this case input cannot be empty AND has to pass custom validation
									if (( $(this).hasClass( options.emailValidationClass ) ) && ( !(isValidEmail( $(this).val() ) ))) {
											showCustomNotification( $(this), 'invalid email', options.shake );
											if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
											invalidFields++;
									} else if (( $(this).hasClass( options.numericValidationClass ) ) && ( !(isNumeric( $(this).val() ) ))){
											showCustomNotification( $(this), 'not numeric', options.shake );
											if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
											invalidFields++;
									} else if (options.showNotifications) {
											hideNotification( $(this) );
									}
								}
						});
					} else {
						//remove notification from secondary inputs
						$("." + options.thenClass + conditionalLoop).each(function(){
							if (options.showNotifications) hideNotification( $(this) );
						});
					}
					
					conditionalLoop++;
				}
			
			
			if  ( invalidFields > 0 ) {
				//scroll up to first invalid field
				if (options.scrollUp) scrollUp(firstInvalidField);
				
				//invalid, don't submit form
				if (options.showMessage) alert(options.message);
				return false;
			}
		});
		//remove notification on keyup or select change
		if (options.showNotifications){
			$("."+options.requiredClass).bind('keyup', function(){
				if ( $(this).val() != "" ) hideNotification( $(this) );
				else showNotification( $(this), options.shake );
			});
			$("select."+options.requiredClass).bind('change', function(){
				if ( $(this).val() != "" ) hideNotification( $(this) );
				else showNotification( $(this), options.shake );
			});
		}
		//append notifications in HTML
		if (options.showNotifications){
			/* insert required fields span after each input */
			$("."+options.requiredClass).each(function(){
					appendNotification( $(this), options.notificationClass, options.notificationText );
			});
		
			//append conditional notifications in HTML
			var conditionalLoop = 1;
				//loop through conditional elements
				while ( $("." + options.ifClass + conditionalLoop).length > 0 ){
					//loop
					$("." + options.thenClass + conditionalLoop).each(function(){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					});
					conditionalLoop++;
				}
    	}	
    });
  }
  function appendNotification(elm,cssClass,text){
		elm.after('<span class="'+ cssClass +'">'+ text +'</span>');
  }
  function showNotification(elm, shakeIt){
		elm.next("span.required-display").fadeIn(200, function(){
			if (shakeIt) shake( $(this) );
		});
  }
   function showCustomNotification(elm,text,shakeIt){
		elm.next("span.required-display").html(text);
		elm.next("span.required-display").fadeIn(200, function(){
			if (shakeIt) shake( $(this) );
		});
  }
  function hideNotification(elm){
		elm.next("span.required-display").fadeOut(200);
  }
  function isValidEmail(email) {
		/* use regex to check for a valid email address */
		var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email)) {
			return false;
		}
		return true;
  }
  function isNumeric(val){
		if (val != parseFloat(val)) return false;
		return true;		
  }
  
  function shake(elm){
  // shake an element from side-to-side
		for (var x = 1; x <= 2; x++){
			$(elm).animate({ "marginLeft" : "-=2px" },20)
			.animate({ "marginLeft" : "+=2px" },20)
			.animate({ "marginLeft" : "+=2px" },20)
			.animate({ "marginLeft" : "-=2px" },20);
		}
		
  }
  
  function scrollUp(elm){
	var px = elm.offset().top - 100;
	//scroll the browser window up 100px before the target element
	if ($.browser.opera){
		$('html').animate({scrollTop: px}, 500);
	} else {
		$('html,body').animate({scrollTop: px}, 500);
	}
  }
  
})(jQuery);