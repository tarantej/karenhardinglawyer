/*

	Supersized - Fullscreen Slideshow jQuery Plugin
	Version : 3.2.0
	Theme 	: Shutter
	
	Site	: www.buildinternet.com/project/supersized
	Author	: Sam Dunn
	Company : One Mighty Roar (www.onemightyroar.com)
	License : MIT License / GPL License

*/

(function($){
	
	theme = {
	 	
	 	
	 	/* Initial Placement
		----------------------------*/
	 	_init : function(){
	 		
	 		// Center Slide Links
	 		if (api.options.slide_links) $(vars.slide_list).css('margin-left', -$(vars.slide_list).width()/2);

		  	// var slide_color = $('.first-slide-fullscreen-slideshow-color').data('color');
		  	// if ( slide_color != undefined) {
		  	// 	$('body').addClass('fullscreen-slide-'+ slide_color );
		  	// }
	 		
			// Start progressbar if autoplay enabled
    		if (api.options.autoplay){
    			if (api.options.progress_bar) theme.progressBar();
			}else{
				if ($(vars.play_button).attr('class', 'ion-ios-pause')) {
					$(vars.play_button).attr('class', 'ion-ios-play');	// If pause play button is image, swap src
				}
				if (api.options.progress_bar) $(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );	//  Place progress bar
			}
			
			
			/* Thumbnail Tray
			----------------------------*/
			// Hide tray off screen
			//$(vars.thumb_tray).animate({bottom : -$(vars.thumb_tray).height()}, 0 );
			// Thumbnail Tray Toggle
			$(vars.tray_button).toggle(function(){
				$(vars.thumb_tray).stop().animate({bottom : -$(vars.thumb_tray).height(), avoidTransforms : true}, 300 );
				if ($(vars.tray_arrow).attr('src')) $(vars.tray_arrow).attr("src", api.options.image_path + "button-tray-up.png");
				return false;
			}, function() {
				$(vars.thumb_tray).stop().animate({bottom : 0, avoidTransforms : true}, 300 );
				if ($(vars.tray_arrow).attr('src')) $(vars.tray_arrow).attr("src", api.options.image_path + "button-tray-down.png");
				return false;
			});
			
			// Make thumb tray proper size
			$(vars.thumb_list).width($('> li', vars.thumb_list).length * $('> li', vars.thumb_list).outerWidth(true));	//Adjust to true width of thumb markers
			if ( $('body').hasClass('fullscreen-coverphoto') || $('body').hasClass('fullscreen-particles') ) {
				//$('#slidecaption,.coverphoto-outer-wrap').fadeIn('fast');
			} else {
				//$('#slidecaption').stop().delay(300).fadeIn(1500);
			}
			// Display total slides
			if ($(vars.slide_total).length){
				$(vars.slide_total).html(api.options.slides.length);
			}

			$('body .slideshow-content-wrap').addClass('display-content');

						// jQuery('.slideshow_title')
						// 	.stop()
						// 	.delay( 10 )
						// 	.animate({ opacity : 1 }, 450, '' );

						// jQuery('.slideshow_caption')
						// 	.stop()
						// 	.delay( 500 )
						// 	.animate({ opacity : 1 }, 450, '' );

						// jQuery('.slideshow_content_links')
						// 	.stop()
						// 	.delay( 700 )
						// 	.animate({ opacity : 1 }, 450, '' );
	
			/* Thumbnail Tray Navigation
			----------------------------*/	
			if (api.options.thumb_links){
				//Hide thumb arrows if not needed
				if ($(vars.thumb_list).width() <= $(vars.thumb_tray).width()){
					$(vars.thumb_back +','+vars.thumb_forward).fadeOut(0);
				}
				
				// Thumb Intervals
        		vars.thumb_interval = Math.floor($(vars.thumb_tray).width() / $('> li', vars.thumb_list).outerWidth(true)) * $('> li', vars.thumb_list).outerWidth(true);
        		vars.thumb_page = 0;
        		
        		// Cycle thumbs forward
        		$(vars.thumb_forward).click(function(){
        			if (vars.thumb_page - vars.thumb_interval <= -$(vars.thumb_list).width()){
        				vars.thumb_page = 0;
        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}else{
        				vars.thumb_page = vars.thumb_page - vars.thumb_interval;
        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}
        		});
        		
        		// Cycle thumbs backwards
        		$(vars.thumb_back).click(function(){
        			if (vars.thumb_page + vars.thumb_interval > 0){
        				vars.thumb_page = Math.floor($(vars.thumb_list).width() / vars.thumb_interval) * -vars.thumb_interval;
        				if ($(vars.thumb_list).width() <= -vars.thumb_page) vars.thumb_page = vars.thumb_page + vars.thumb_interval;
        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
					}else{
        				vars.thumb_page = vars.thumb_page + vars.thumb_interval;
        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}
        		});
				
			}
			
			
			/* Navigation Items
			----------------------------*/
		    $(vars.next_slide).click(function() {
		    	api.nextSlide();
		    });
		    
		    $(vars.prev_slide).click(function() {
		    	api.prevSlide();
		    });
		    
		    	// Full Opacity on Hover
		    	if(jQuery.support.opacity){
			    	$(vars.prev_slide +','+vars.next_slide).mouseover(function() {
					   //$(this).stop().animate({opacity:1},100);
					}).mouseout(function(){
					   //$(this).stop().animate({opacity:0.8},100);
					});
				}
			
			if (api.options.thumbnail_navigation){
				// Next thumbnail clicked
				$(vars.next_thumb).click(function() {
			    	api.nextSlide();
			    });
			    // Previous thumbnail clicked
			    $(vars.prev_thumb).click(function() {
			    	api.prevSlide();
			    });
			}
			
		    $(vars.play_button).click(function() {
				api.playToggle();						    
		    });
			
			
			/* Thumbnail Mouse Scrub
			----------------------------*/
    		if (api.options.mouse_scrub){
				$(vars.thumb_tray).mousemove(function(e) {
					var containerWidth = $(vars.thumb_tray).width(),
						listWidth = $(vars.thumb_list).width();
					if (listWidth > containerWidth){
						var mousePos = 1,
							diff = e.pageX - mousePos;
						if (diff > 10 || diff < -10) { 
						    mousePos = e.pageX; 
						    newX = (containerWidth - listWidth) * (e.pageX/containerWidth);
						    diff = parseInt(Math.abs(parseInt($(vars.thumb_list).css('left'))-newX )).toFixed(0);
						    $(vars.thumb_list).stop().animate({'left':newX}, {duration:diff*3, easing:'easeOutExpo'});
						}
					}
				});
			}
			
			
			/* Window Resize
			----------------------------*/
			$(window).resize(function(){
				
				// Delay progress bar on resize
				if (api.options.progress_bar && !vars.in_animation){
					if (vars.slideshow_interval) clearInterval(vars.slideshow_interval);
					if (api.options.slides.length - 1 > 0) clearInterval(vars.slideshow_interval);
					
					$(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
					
					if (!vars.progressDelay && api.options.slideshow){
						// Delay slideshow from resuming so Chrome can refocus images
						vars.progressDelay = setTimeout(function() {
								if (!vars.is_paused){
									theme.progressBar();
									vars.slideshow_interval = setInterval(api.nextSlide, api.options.slide_interval);
								}
								vars.progressDelay = false;
						}, 1000);
					}
				}
				
				// Thumb Links
				if (api.options.thumb_links && vars.thumb_tray.length){
					// Update Thumb Interval & Page
					vars.thumb_page = 0;	
					vars.thumb_interval = Math.floor($(vars.thumb_tray).width() / $('> li', vars.thumb_list).outerWidth(true)) * $('> li', vars.thumb_list).outerWidth(true);
					
					// Adjust thumbnail markers
					if ($(vars.thumb_list).width() > $(vars.thumb_tray).width()){
						$(vars.thumb_back +','+vars.thumb_forward).fadeIn('fast');
						$(vars.thumb_list).stop().animate({'left':0}, 200);
					}else{
						$(vars.thumb_back +','+vars.thumb_forward).fadeOut('fast');
					}
					
				}
			});	
			
								
	 	},
	 	
	 	
	 	/* Go To Slide
		----------------------------*/
	 	goTo : function(){
	 		if (api.options.progress_bar && !vars.is_paused){
				$(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
				theme.progressBar();
			}
		},
	 	
	 	/* Play & Pause Toggle
		----------------------------*/
	 	playToggle : function(state){
	 		
	 		if (state =='play'){
	 			// If image, swap to pause
	 			if ($(vars.play_button).attr('class', 'ion-ios-play')) {
					$(vars.play_button).attr('class', 'ion-ios-pause');	// If pause play button is image, swap src
				}
				if (api.options.progress_bar && !vars.is_paused) theme.progressBar();
	 		}else if (state == 'pause'){
	 			// If image, swap to play
	 			if ($(vars.play_button).attr('class', 'ion-ios-pause')) {
					$(vars.play_button).attr('class', 'ion-ios-play');	// If pause play button is image, swap src
				}
				if (api.options.progress_bar && vars.is_paused)$(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
	 		}
	 		
	 	},
	 	SetPause : function(state){
 			if ($(vars.play_button).attr('class', 'ion-ios-pause')) {
				$(vars.play_button).attr('class', 'ion-ios-play');	// If pause play button is image, swap src
			}
			if (api.options.progress_bar && vars.is_paused)$(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
	 	},
	 	SetPlay : function(state){
 			// If image, swap to pause
 			if ($(vars.play_button).attr('class', 'ion-ios-play')) {
				$(vars.play_button).attr('class', 'ion-ios-pause');	// If pause play button is image, swap src
			}
			if (api.options.progress_bar && !vars.is_paused) theme.progressBar();
	 	},
	 	
	 	
	 	/* Before Slide Transition
		----------------------------*/
	 	beforeAnimation : function(direction){
		    if (api.options.progress_bar && !vars.is_paused) $(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 );
		  	//console.log(vars.current_slide);
			
		// titles animation
		// 

			$('body .slideshow-content-wrap').removeClass('display-content');

				// jQuery('.slideshow_content_links')
				// 	.stop()
				// 	.delay( 10 )
				// 	.animate({ opacity : 0 }, 450, '' );
				
				// jQuery('.slideshow_caption')
				// 	.stop()
				// 	.delay( 500 )
				// 	.animate({ opacity : 0 }, 450, '' );

				// jQuery('.slideshow_title')
				// 	.stop()
				// 	.delay( 700 )
				// 	.animate({ opacity : 0 }, 450, '' );

		    //check slide number and add an assistive class to body for color change
		    	var proceed_change_ui = true;
		    	if ( $('body').hasClass('page-is-not-fullscreen') && $('body').hasClass('page-media-background') ) {
		    		proceed_change_ui = false;
		    	}
		    	if ( $('body').hasClass('fullscreen-mode-on') ) {
		    		proceed_change_ui = true;
		    	}
		    	if ( $('body').hasClass('fullscreen-ui-switchable') ) {
		    		proceed_change_ui = true;
		    	} else {
		    		proceed_change_ui = false;
		    	}

			  	var slide_color = $('#slideshow-data .slide-' + vars.current_slide).data('color');
			  	if ( slide_color != undefined) {
			  		//console.log('reached');
			  		//jQuery('.slideshow_caption,.slideshow_title,.slideshow_content_link').hide();
			  		if ( proceed_change_ui ) {
				  		$('body').removeClass('fullscreen-slide-bright');
				  		$('body').removeClass('fullscreen-slide-dark');
				  		$('body').addClass('fullscreen-slide-'+ slide_color );
			  		}
			  		$('#slideshow-data li').removeClass('data-active-slide');
			  		$('#slideshow-data .slide-' + vars.current_slide).addClass('data-active-slide');
			  	}
		  	
		  	if ( !$('#slideshow-text-box').hasClass('coverphoto-static-text') ) {

				// $('.fullscreen-particles .coverphoto-outer-wrap').hide();
				// $('.fullscreen-coverphoto .coverphoto-outer-wrap').hide();
								
				//$('#slidecaption,.coverphoto-outer-wrap').stop().fadeOut('fast', function() {
					//console.log('Reached outer 1');
				  	/* Update Fields
				  	----------------------------*/
				  	// Update slide caption

				//});
				   	if ($(vars.slide_caption).length){
				   		(api.getField('title')) ? $(vars.slide_caption).html(api.getField('title')) : $(vars.slide_caption).html('');
					    // titles animation
				   	}

			}
		  	

		    // Update slide number
			if (vars.slide_current.length){
			    $(vars.slide_current).html(vars.current_slide + 1);
			}
		    
		    
		    // Highlight current thumbnail and adjust row position
		    if (api.options.thumb_links){
		    
				$('.current-thumb').removeClass('current-thumb');
				$('li', vars.thumb_list).eq(vars.current_slide).addClass('current-thumb');
				
				// If thumb out of view
				if ($(vars.thumb_list).width() > $(vars.thumb_tray).width()){
					// If next slide direction
					if (direction == 'next'){
						if (vars.current_slide == 0){
							vars.thumb_page = 0;
							$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						} else if ($('.current-thumb').offset().left - $(vars.thumb_tray).offset().left >= vars.thumb_interval){
	        				vars.thumb_page = vars.thumb_page - vars.thumb_interval;
	        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						}
					// If previous slide direction
					}else if(direction == 'prev'){
						if (vars.current_slide == api.options.slides.length - 1){
							vars.thumb_page = Math.floor($(vars.thumb_list).width() / vars.thumb_interval) * -vars.thumb_interval;
							if ($(vars.thumb_list).width() <= -vars.thumb_page) vars.thumb_page = vars.thumb_page + vars.thumb_interval;
							$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						} else if ($('.current-thumb').offset().left - $(vars.thumb_tray).offset().left < 0){
							if (vars.thumb_page + vars.thumb_interval > 0) return false;
	        				vars.thumb_page = vars.thumb_page + vars.thumb_interval;
	        				$(vars.thumb_list).stop().animate({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						}
					}
				}
				
				
			}
		    
	 	},
	 	
	 	
	 	/* After Slide Transition
		----------------------------*/
	 	afterAnimation : function(){
			if ( $('body').hasClass('fullscreen-coverphoto') || $('body').hasClass('fullscreen-particles') ) {
				//$('#slidecaption,.coverphoto-outer-wrap').fadeIn('fast');
			} else {
				//$('#slidecaption').delay(300).fadeIn(1500);
			}
	 		if (api.options.progress_bar && !vars.is_paused) theme.progressBar();	//  Start progress bar
			
			    // titles animation
			    // 
			    $('body .slideshow-content-wrap').addClass('display-content');
				// jQuery('.slideshow_title')
				// 	.stop()
				// 	.delay( 10 )
				// 	.animate({ opacity : 1 }, 450, '' );

				// jQuery('.slideshow_caption')
				// 	.stop()
				// 	.delay( 500 )
				// 	.animate({ opacity : 1 }, 450, '' );

				// jQuery('.slideshow_content_links')
				// 	.stop()
				// 	.delay( 700 )
				// 	.animate({ opacity : 1 }, 450, '' );		
			
	 	},
	 	
	 	
	 	/* Progress Bar
		----------------------------*/
		progressBar : function(){
    		$(vars.progress_bar).stop().animate({left : -$(window).width()}, 0 ).animate({ left:0 }, api.options.slide_interval);
    	}
	 	
	 
	 };
	 
	 /* Theme Specific Variables
	 ----------------------------*/
	 $.supersized.themeVars = {
	 	
	 	// Internal Variables
		progress_delay		:	false,				// Delay after resize before resuming slideshow
		thumb_page 			: 	false,				// Thumbnail page
		thumb_interval 		: 	false,				// Thumbnail interval
		
													
		// General Elements							
		play_button			:	'#pauseplay',		// Play/Pause button
		next_slide			:	'#nextslide',		// Next slide button
		prev_slide			:	'#prevslide',		// Prev slide button
		next_thumb			:	'#nextthumb',		// Next slide thumb button
		prev_thumb			:	'#prevthumb',		// Prev slide thumb button
		
		slide_caption		:	'#slidecaption',	// Slide caption
		slide_current		:	'.slidenumber',		// Current slide number
		slide_total			:	'.totalslides',		// Total Slides
		slide_list			:	'#slide-list',		// Slide jump list							
		
		thumb_tray			:	'#thumb-tray',		// Thumbnail tray
		thumb_list			:	'#thumb-list',		// Thumbnail list
		thumb_forward		:	'#thumb-forward',	// Cycles forward through thumbnail list
		thumb_back			:	'#thumb-back',		// Cycles backwards through thumbnail list
		tray_arrow			:	'#tray-arrow',		// Thumbnail tray button arrow
		tray_button			:	'#tray-button',		// Thumbnail tray button
		
		progress_bar		:	'#progress-bar'		// Progress bar
	 												
	 };												
	
	 /* Theme Specific Options
	 ----------------------------*/												
	 $.supersized.themeOptions = {					
	 						   
		progress_bar		:	1,		// Timer for each slide											
		mouse_scrub			:	0		// Thumbnails move with mouse
		
	 };
	
	
})(jQuery);