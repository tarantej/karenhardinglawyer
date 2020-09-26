jQuery(document).ready(function($) {
	"use strict";

    $(".metabox-image-radio-selector").live('click', function() {
    	var check_radio_selector = $(this).data('holder');
    	$("#"+check_radio_selector).prop("checked", true);
    });

	var frame,
	    images = kreativa_admin_vars.post_gallery,
	    selection = loadImages(images);

	$('#mtheme_images_upload').on('click', function(e) {
		e.preventDefault();

		// Set options for 1st frame render
		var options = {
			title: 'Create Featured Gallery',
			state: 'gallery-edit',
			frame: 'post',
			selection: selection
		};

		// Check if frame or gallery already exist
		if( frame || selection ) {
			options['title'] = 'Edit Featured Gallery';
		}

		frame = wp.media(options).open();
		
		// Tweak views
		frame.menu.get('view').unset('cancel');
		frame.menu.get('view').unset('separateCancel');
		frame.menu.get('view').get('gallery-edit').el.innerHTML = 'Edit Featured Gallery';
		frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

		// When we are editing a gallery
		overrideGalleryInsert();
		frame.on( 'toolbar:render:gallery-edit', function() {
			overrideGalleryInsert();
		});
		
		frame.on( 'content:render:browse', function( browser ) {
		    if ( !browser ) return;
		    // Hide Gallery Settings in sidebar
		    browser.sidebar.on('ready', function(){
		        browser.sidebar.unset('gallery');
		    });
		});
		
		// All images removed
		frame.state().get('library').on( 'remove', function() {
		    var models = frame.state().get('library');
			if(models.length == 0){
			    selection = false;
				$.post(ajaxurl, { ids: '', action: 'kreativa_save_images', post_id: kreativa_admin_vars.post_id, nonce: kreativa_admin_vars.nonce });
			}
		});
		
		// Override insert button
		function overrideGalleryInsert() {
			frame.toolbar.get('view').set({
				insert: {
					style: 'primary',
					text: 'Save Featured Gallery',

					click: function() {
						var models = frame.state().get('library'),
						    ids = '';

						models.each( function( attachment ) {
						    ids += attachment.id + ','
						});

						this.el.innerHTML = 'Saving...';
						
						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: { 
								ids: ids, 
								action: 'kreativa_save_images', 
								post_id: kreativa_admin_vars.post_id, 
								nonce: kreativa_admin_vars.nonce 
							},
							success: function(){
								selection = loadImages(ids);
								$('#_mtheme_image_ids').val( ids );
								frame.close();
							},
							dataType: 'html'
						}).done( function( data ) {
							$('.mtheme-gallery-thumbs').html( data );
						}); 
					}
				}
			});
		}
	});
	
	// Load images
	function loadImages(images) {
		if( images ){
		    var shortcode = new wp.shortcode({
				tag:    'gallery',
				attrs:   { ids: images },
				type:   'single'
			});

		    var attachments = wp.media.gallery.attachments( shortcode );

			var selection = new wp.media.model.Selection( attachments.models, {
				props:    attachments.props.toJSON(),
				multiple: true
			});

			selection.gallery = attachments.gallery;
			
			// Fetch the query's attachments, and then break ties from the
			// query to allow for sorting.
			selection.more().done( function() {
				// Break ties with the query.
				selection.props.set({ query: false });
				selection.unmirror();
				selection.props.unset('orderby');
			});
			
			return selection;
		}
		
		return false;
	}



	$('.meta-multi-upload').on('click', function(e) {
		e.preventDefault();

		// Load images
		function multi_loadImages(multi_images) {
			if( multi_images ){
			    var shortcode = new wp.shortcode({
					tag:    'gallery',
					attrs:   { ids: multi_images },
					type:   'single'
				});

			    var attachments = wp.media.gallery.attachments( shortcode );

				var selection = new wp.media.model.Selection( attachments.models, {
					props:    attachments.props.toJSON(),
					multiple: true
				});

				selection.gallery = attachments.gallery;
				
				// Fetch the query's attachments, and then break ties from the
				// query to allow for sorting.
				selection.more().done( function() {
					// Break ties with the query.
					selection.props.set({ query: false });
					selection.unmirror();
					selection.props.unset('orderby');
				});
				
				return selection;
			}
			
			return false;
		}

		var frame,
		    thisInput = $(this),
		    multi_images = $(this).data('imageset'),
		    galleryid = $(this).data('galleryid'),
		    selection = multi_loadImages(multi_images);

		// Set options for 1st frame render
		var options = {
			title: 'Create Featured Gallery',
			state: 'gallery-edit',
			frame: 'post',
			selection: selection
		};

		// Check if frame or gallery already exist
		if( frame || selection ) {
			options['title'] = 'Edit Featured Gallery';
		}

		frame = wp.media(options).open();
		
		// Tweak views
		frame.menu.get('view').unset('cancel');
		frame.menu.get('view').unset('separateCancel');
		frame.menu.get('view').get('gallery-edit').el.innerHTML = 'Edit Featured Gallery';
		frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

		// When we are editing a gallery
		multi_overrideGalleryInsert();
		frame.on( 'toolbar:render:gallery-edit', function() {
			multi_overrideGalleryInsert();
		});
		
		frame.on( 'content:render:browse', function( browser ) {
		    if ( !browser ) return;
		    // Hide Gallery Settings in sidebar
		    browser.sidebar.on('ready', function(){
		        browser.sidebar.unset('gallery');
		    });
		});
		
		// All images removed
		frame.state().get('library').on( 'remove', function() {
		    var models = frame.state().get('library');
			if(models.length == 0){
			    selection = false;
				$.post(ajaxurl, { ids: '', action: 'multo_gallery_save_images', gallerysetid: galleryid, post_id: kreativa_admin_vars.post_id, nonce: kreativa_admin_vars.nonce });
			}
		});
		
		// Override insert button
		function multi_overrideGalleryInsert() {
			frame.toolbar.get('view').set({
				insert: {
					style: 'primary',
					text: 'Save Featured Gallery',

					click: function() {
						var models = frame.state().get('library'),
						    ids = '';

						models.each( function( attachment ) {
						    ids += attachment.id + ','
						});

						this.el.innerHTML = 'Saving...';
						
						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: { 
								ids: ids, 
								gallerysetid: galleryid,
								action: 'multo_gallery_save_images', 
								post_id: kreativa_admin_vars.post_id, 
								nonce: kreativa_admin_vars.nonce 
							},
							success: function(){
								selection = multi_loadImages(ids);
								$('#'+galleryid).val( ids );
								thisInput.data( 'imageset' , ids );
								frame.close();
							},
							dataType: 'html'
						}).done( function( data ) {
							$('.multi-gallery-'+galleryid).html( data );
						}); 
					}
				}
			});
		}
	});

});