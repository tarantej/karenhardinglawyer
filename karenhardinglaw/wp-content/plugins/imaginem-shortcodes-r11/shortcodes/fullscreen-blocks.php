<?php
// PageMeta
add_shortcode("display_pagemeta_infobox", "mtheme_PageMeta_Infobox");
function mtheme_PageMeta_Infobox($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '3',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	//$limit= imaginem_codepack_get_option_data('information_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="3";
	}

	$portfolioImage_type="kreativa-gridblock-events";

	if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
	    $_type  = get_post_type($curr_pageid);
	    $curr_pageid = icl_object_id($curr_pageid, $_type, true, ICL_LANGUAGE_CODE);
	}
	$filter_image_ids = imaginem_codepack_get_pagemeta_infobox_set ( get_the_id() );
	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="fullscreen-informationbox-outer clearfix">';
	$output .= '<div class="gridblock-owlcarousel-wrap fullscreen-informationbox-inner mtheme-events-carousel clearfix">';
	$output .= '<div id="owl-fullscreen-pagemeta" class="owl-carousel owl-slideshow-element">';
	
			foreach ( $filter_image_ids as $attachment_id) {
				$attachment = get_post( $attachment_id );
				if ( isSet($attachment_id) && $attachment_id<>"" ) {
					$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
					$caption = $attachment->post_excerpt;
					//$href = get_permalink( $attachment->ID ),
					$imageURI = wp_get_attachment_image_src( $attachment_id, 'kreativa-gridblock-square-big', false );
					$imageURI = $imageURI[0];
					$imageTitle = $attachment->post_title;
					$imageDesc = $attachment->post_content;

					$thumb_imageURI = '';

					$link_text = ''; $link_url = ''; $slideshow_link = ''; $slideshow_color='';
					$link_text = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_link', true );
					$link_url = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_url', true );
					$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );

			
					$output .= '<div class="slideshow-box-wrapper clearfix" data-card="'.$attachment_id.'">';
						$output .= '<div class="slideshow-box-image">';

						
							$output .= '<a href="'.esc_url( $link_url ).'">';

							if ( isSet($imageURI[0]) ) {
								$output .= imaginem_codepack_display_post_image (
									get_the_ID(),
									$have_image_url=$imageURI,
									$link=false,
									$theimage_type=$portfolioImage_type,
									$imagetitle='',
									$class="displayed-image"
								);
							} else {
								$output .= '<div class="gridblock-protected">';
									$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
									$protected_placeholder = '/images/blank-grid.png';
									$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
								$output .= '</div>';

							}
							$output .= '</a>';	

						$output .= '</div>';
						$output .= '<div class="slideshow-box-content">';
							$output .= '<div class="slideshow-box-content-inner">';
							
								$output .= '<a href="'.esc_url( $link_url ).'">';
									$output .= '<h2>'.$imageTitle.'</h2>';

									$output .= '<div class="slideshow-box-description">';
										$output .= $imageDesc;
									$output .='</div>';
									$output .= "<div class='slideshow-box-readmore hover-color-transtition'>Read More</div>";
								$output .='</a>';

							$output .= '</div>';
						$output .= '</div>';
					$output .='</div>';
				}

			}
	$output .='</div>';
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;
}
// Portfolio
function mtheme_Worktype_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	$limit= imaginem_codepack_get_option_data('worktype_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="";
	}
	
	//echo $type, $portfolio_type;
	if ($worktype_slugs!='') $all_works = explode(",", $worktype_slugs);
	$categories=  get_categories('orderby=slug&taxonomy=types&number='.$limit.'&title_li=');

	$portfolioImage_type="kreativa-gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. imaginem_codepack_get_option_data('worktype_box_title') . '</div>';
	$output .= '<div id="owl-fullscreen-infobox" class="owl-carousel owl-slideshow-element">';
	
			foreach ($categories as $category){
				$taxonomy = "types";

				$term_slug = $category->slug;
				$term = get_term_by('slug', $term_slug, $taxonomy);

				if ( !isSet($all_works) || in_array($term_slug, $all_works) ) {				

					$hreflink = get_term_link($category->slug,'types');
					$mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $category->term_id);
					$work_type_image = wp_get_attachment_image_src( $mtheme_worktype_image_id, $portfolioImage_type , false );

			
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
						$output .= '<a href="'.esc_url( $hreflink ).'">';

						if ( isSet($work_type_image[0]) ) {
							$output .= imaginem_codepack_display_post_image (
								get_the_ID(),
								$have_image_url=$work_type_image[0],
								$link=false,
								$theimage_type=$portfolioImage_type,
								$imagetitle='',
								$class="displayed-image"
							);
						} else {
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/blank-grid.png';
							$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';

						}
						$output .= '</a>';	

					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<h2 class="slideshow-box-title">';
					
					$output .= '<a href="'.esc_url( $hreflink ).'">'. $category->name . '</a>';
					$output .= '</h2>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $category->description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			}
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_worktype_infobox_slideshow", "mtheme_Worktype_Infobox_Slideshow");
// Portfolio
function mtheme_Portfolio_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	$limit= imaginem_codepack_get_option_data('portfolio_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'mtheme_portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $limit
		));	

	$portfolioImage_type="kreativa-gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$portfolio_box_heading = imaginem_codepack_get_option_data('portfolio_box_title');
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. $portfolio_box_heading . '</div>';
	$output .= '<div id="owl-fullscreen-infobox" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description="";
			$customlink_URL='';
			$thumbnail='';
			if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { $description=$custom['pagemeta_thumbnail_desc'][0]; }
			if ( isset($custom['pagemeta_customlink'][0]) ) { $customlink_URL=$custom['pagemeta_customlink'][0]; }
			if ( isset($custom['pagemeta_customthumbnail'][0]) ) { $thumbnail=$custom['pagemeta_customthumbnail'][0]; }
			
			
				$output .= '<div class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				
				if ( has_post_thumbnail() ) {
					if ($customlink_URL<>"") {
						$output .= '<a href="'.esc_url($customlink_URL).'">';
					} else {
						$output .= '<a href="'.get_permalink().'">';
					}
					if ($thumbnail<>"") {
						$output .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
					} else {
						$output .= imaginem_codepack_display_post_image (
							get_the_ID(),
							$have_image_url="",
							$link=false,
							$theimage_type=$portfolioImage_type,
							$imagetitle='',
							$class="displayed-image"
							);
					}
					$output .= '</a>';
				} else {
						if ($customlink_URL<>"") {
							$output .= '<a href="'.esc_url($customlink_URL).'">';
						} else {
							$output .= '<a href="'.get_permalink().'">';
						}
						$output .= '<div class="gridblock-protected">';
						$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
						$protected_placeholder = '/images/blank-grid.png';
						$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
						$output .= '</div>';
					$output .= '</a>';						
				}	
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<h2 class="slideshow-box-title">';
				if ($customlink_URL<>"") {
					$output .= '<a href="'.esc_url($customlink_URL).'">'.get_the_title() . '</a>';
				} else {
					$output .= '<a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a>';
				}
				$output .= '</h2>';

				$output .= '<div class="slideshow-box-description">';
					$output .= $description;
				$output .='</div>';

				$output .= '</div></div>';
				$output .='</div>';

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_portfolio_infobox_slideshow", "mtheme_Portfolio_Infobox_Slideshow");
// Events
function mtheme_Events_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"autoheight" => 'true'
	), $atts));

	$limit= imaginem_codepack_get_option_data('events_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'mtheme_events',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $limit,
		'meta_query'	=> array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> 'pagemeta_event_notice',
				'value'	  	=> 'inactive',
				'compare' 	=> 'NOT IN',
			),
		),
		));	

	$portfolioImage_type="kreativa-gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. imaginem_codepack_get_option_data('event_box_title') . '</div>';
	$output .= '<div id="owl-fullscreen-infobox" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description="";
			if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { $description=$custom['pagemeta_thumbnail_desc'][0]; }
			
			
				$output .= '<div class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				
				if ( has_post_thumbnail() ) {
					$output .= '<a href="'.get_permalink().'">';
					$output .= imaginem_codepack_display_post_image (
						get_the_ID(),
						$have_image_url="",
						$link=false,
						$theimage_type=$portfolioImage_type,
						$imagetitle='',
						$class="displayed-image"
					);
					$output .= '</a>';
				} else {
					$output .= '<a href="'.get_permalink().'">';
						$output .= '<div class="gridblock-protected">';
						$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
						$protected_placeholder = '/images/blank-grid.png';
						$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
						$output .= '</div>';
					$output .= '</a>';						
				}
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<h2 class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></h2>';

				$output .= '<div class="slideshow-box-description">';
					$output .= $description;
				$output .='</div>';

				$output .= '</div></div>';
				$output .='</div>';

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_events_infobox_slideshow", "mtheme_Events_Infobox_Slideshow");
//Blog Carousel
function mtheme_Blog_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"category_name" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"cat_slug"=> ''
	), $atts));

	$limit= imaginem_codepack_get_option_data('blog_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'category_name' => $cat_slug,
		'posts_per_page' => $limit
		));	

	$portfolioImage_type="kreativa-gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. imaginem_codepack_get_option_data('blog_box_title') . '</div>';
	$output .= '<div id="owl-fullscreen-infobox" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$postformat = get_post_format();
			if($postformat == "") {
				$postformat="standard";
			}
			$custom = get_post_custom(get_the_ID());
			$description= imaginem_codepack_trim_sentence( get_the_excerpt() , 120 );
			if ( $postformat == "quote") {
				$description = get_post_meta(get_the_id(), 'pagemeta_meta_quote', true);
			}
			
				if ( has_post_thumbnail() ) {
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
					if ( has_post_thumbnail() ) {
						$output .= '<a href="'.get_permalink().'">';
						$output .= imaginem_codepack_display_post_image (
							get_the_ID(),
							$have_image_url="",
							$link=false,
							$theimage_type=$portfolioImage_type,
							$imagetitle='',
							$class="displayed-image"
						);
						$output .= '</a>';
					} else {
						$output .= '<a href="'.get_permalink().'">';
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/blank-grid.png';
							$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';						
					}	
					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<h2 class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></h2>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_blog_infobox_slideshow", "mtheme_Blog_Infobox_Slideshow");
//WooCommerce Slideshows
function mtheme_WooCommerce_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"category_name" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"cat_slug"=> ''
	), $atts));

	$limit= imaginem_codepack_get_option_data('woocommerce_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'product',
		'posts_per_page' => $limit
		));	

	$portfolioImage_type="kreativa-gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. imaginem_codepack_get_option_data('woocommerce_box_title') . '</div>';
	$output .= '<div id="owl-fullscreen-infobox" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description= imaginem_codepack_trim_sentence( get_the_excerpt() , 60 );
			
				if ( has_post_thumbnail() ) {
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
					if ( has_post_thumbnail() ) {
						$output .= '<a href="'.get_permalink().'">';
						$output .= imaginem_codepack_display_post_image (
							get_the_ID(),
							$have_image_url="",
							$link=false,
							$theimage_type=$portfolioImage_type,
							$imagetitle='',
							$class="displayed-image"
						);
						$output .= '</a>';
					} else {
						$output .= '<a href="'.get_permalink().'">';
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/blank-grid.png';
							$output .= '<img src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';						
					}
					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<h2 class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></h2>';

					ob_start();
					woocommerce_get_template('loop/price.php');
					$woo_price = ob_get_contents();
					ob_end_clean();

					$output .= '<div class="slideshow-box-price">'.$woo_price.'</div>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_woocommerce_infobox_slideshow", "mtheme_WooCommerce_Infobox_Slideshow");
?>