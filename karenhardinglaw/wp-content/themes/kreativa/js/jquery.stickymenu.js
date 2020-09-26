jQuery(document).ready(function($){
	"use strict";
	
	if ($('body').hasClass('menu-is-horizontal')) {
		var stickyNavTop = 800;
		var stickyOutofSight = 200;

		var stickyNav = function(){
			var scrollTop = $(window).scrollTop();
			     
			if (scrollTop > stickyNavTop) { 
			   $('body').addClass('stickymenu-active');
			} else {
			   $('body').removeClass('stickymenu-active');
			}

			if (scrollTop > stickyOutofSight) { 
			   $('body').addClass('menu-outofsight');
			} else {
			   $('body').removeClass('menu-outofsight');
			}
		};

		stickyNav();

		$(window).scroll(function() {
			stickyNav();
		});
	}
});
