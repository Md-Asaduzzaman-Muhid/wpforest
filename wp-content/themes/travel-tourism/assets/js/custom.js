function travel_tourism_menu_open_nav() {
	window.travel_tourism_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function travel_tourism_menu_close_nav() {
	window.travel_tourism_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   	});
});

jQuery(document).ready(function () {
	window.travel_tourism_currentfocus=null;
  	travel_tourism_checkfocusdElement();
	var travel_tourism_body = document.querySelector('body');
	travel_tourism_body.addEventListener('keyup', travel_tourism_check_tab_press);
	var travel_tourism_gotoHome = false;
	var travel_tourism_gotoClose = false;
	window.travel_tourism_responsiveMenu=false;
 	function travel_tourism_checkfocusdElement(){
	 	if(window.travel_tourism_currentfocus=document.activeElement.className){
		 	window.travel_tourism_currentfocus=document.activeElement.className;
	 	}
 	}
 	function travel_tourism_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.travel_tourism_responsiveMenu){
			if (!e.shiftKey) {
				if(travel_tourism_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				travel_tourism_gotoHome = true;
			} else {
				travel_tourism_gotoHome = false;
			}

		}else{

			if(window.travel_tourism_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.travel_tourism_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.travel_tourism_responsiveMenu){
				if(travel_tourism_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					travel_tourism_gotoClose = true;
				} else {
					travel_tourism_gotoClose = false;
				}
			
			}else{

			if(window.travel_tourism_responsiveMenu){
			}}}}
		}
	 	travel_tourism_checkfocusdElement();
	}
});

jQuery('document').ready(function($){
	jQuery(window).load(function() {
	    jQuery("#status").fadeOut();
	    jQuery("#preloader").delay(1000).fadeOut("slow");
	})
});

jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
	    if (jQuery(this).scrollTop() > 100) {
	        jQuery('.scrollup i').fadeIn();
	    } else {
	        jQuery('.scrollup i').fadeOut();
	    }
	});
	jQuery('.scrollup').click(function () {
	    jQuery("html, body").animate({
	        scrollTop: 0
	    }, 600);
	    return false;
	});
});

jQuery(document).ready(function() {
	var owl = jQuery('#services-sec .owl-carousel');
		owl.owlCarousel({
			nav: true,
			autoplay:false,
			autoplayTimeout:2000,
			autoplayHoverPause:true,
			loop: true,
			navText : ['<i class="fas fa-long-arrow-alt-left"></i>','<i class="fas fa-long-arrow-alt-right"></i>'],
			responsive: {
			  0: {
			    items: 2
			  },
			  600: {
			    items: 4
			  },
			  1000: {
			    items: 5
			}
		}
	})
})