<?php
/**
 * Photowall
 */
get_header();
$featured_page = kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
	$_type  = get_post_type($featured_page);
	$featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$count=0;
$custom = get_post_custom($featured_page);
$slideshow_titledesc="enable";
if (isSet($custom["pagemeta_photowall_type"][0])) $photowall_type=$custom["pagemeta_photowall_type"][0];
if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];
if (isSet($custom["pagemeta_photowall_workstypes"][0])) {
	$worktype_slugs=$custom["pagemeta_photowall_workstypes"][0];
} else {
	$worktype_slugs="";
}
$limit=-1;
?>
<?php
if ( post_password_required() ) {
	get_template_part( 'password', 'box' );
} else {
	?>
	<div class="photowall-wrap">
		<div id="photowall-container">
			<?php
			$animation_class='';
// Don't Populate list if no Featured page is set
			if ( $featured_page <>"" ) { 
				if ($photowall_type=="portfolio") {

					$count=0;
					$terms=array();
					$work_slug_array=array();
					$args = array();
					if ($worktype_slugs != "") {
						$type_explode = explode(",", $worktype_slugs);
						foreach ($type_explode as $work_slug) {
							$terms[] = $work_slug;
						}
						$args = array(
							'post_type' => 'mtheme_portfolio',
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'paged' => $paged,
							'posts_per_page' => $limit,
							'tax_query' => array(
								array(
									'taxonomy' => 'types',
									'field' => 'slug',
									'terms' => $terms,
									'operator' => 'IN'
									)
								)
							);
					} else {
						$args = array(
							'post_type' => 'mtheme_portfolio',
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'paged' => $paged,
							'posts_per_page' => $limit
							);	
					}

					$portfoliowall = new WP_Query( $args );

					if ( $portfoliowall->have_posts()) : while ( $portfoliowall->have_posts()) : $portfoliowall->the_post();

					$custom = get_post_custom(get_the_ID());
					if ( isset($custom['pagemeta_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom['pagemeta_thumbnail_linktype'][0]; }
					if ( isset($custom['pagemeta_lightbox_video'][0]) ) { $lightboxvideo=$custom['pagemeta_lightbox_video'][0]; }
					if ( isset($custom['pagemeta_customthumbnail'][0]) ) { $thumbnail=$custom['pagemeta_customthumbnail'][0]; }
					if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { $description=$custom['pagemeta_thumbnail_desc'][0]; }
					if ( isset($custom['pagemeta_customlink'][0]) ) { $customlink_URL=$custom['pagemeta_customlink'][0]; }
					if ( isset($custom['pagemeta_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom['pagemeta_portfoliotype'][0]; }

					$imageTitle= get_the_title();
					if ($description) $slideshow_caption= $description;

					echo '<div class="photowall-item photowall-item-presence photowall-item-not-visible">';
					if ( $portfolio_link_type == "Customlink" ) {
						echo '<a href="'.$customlink_URL.'" data-title="'.get_the_title().'">';
					} else {
						echo '<a href="'.get_permalink().'" data-title="'.get_the_title().'">';
					}
				// Slideshow then generate slideshow shortcode

					echo kreativa_display_post_image (
						get_the_ID(),
						$have_image_url="",
						$link=false,
						$type="kreativa-gridblock-full-medium",
						get_the_title(),
						$class="photowall-image"
						);

					if ($slideshow_titledesc=="enable") {
						echo '<div class="photowall-content-wrap">';
						echo '<div class="photowall-box">';				
						if ($imageTitle || $description) {
							if ($imageTitle) {
								echo '<div class="photowall-title"><span>' . $imageTitle . '</span></div>';
							}
							if ($description) {
								echo '<div class="photowall-desc"><span>' . $description . '</span></div>';
							}
						}
						echo '</div>';
						echo '</div>';
					}
					echo '</a>';
					echo '</div>';

					endwhile; endif;

					wp_reset_postdata();

				} else {
					
					$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );

					if ($filter_image_ids) {
						foreach ( $filter_image_ids as $attachment_id) {

							$attachment = get_post( $attachment_id );

							if (isSet($attachment->ID)) {
								$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
								$caption = $attachment->post_excerpt;
				//$href = get_permalink( $attachment->ID ),
								$imageURI = $attachment->guid;

								$thumb_imagearray = wp_get_attachment_image_src( $attachment->ID , 'kreativa-gridblock-full-medium', false);
								$thumb_imageURI = $thumb_imagearray[0];

								$imageTitle = apply_filters('the_title',$attachment->post_title);
								$imageDesc = apply_filters('the_content',$attachment->post_content);
				// Count
								$count++;

								$slideshow_title="";
								$slideshow_caption="";
								
								if ($imageTitle) $slideshow_title='<div class="slideshow_title">'. esc_html($imageTitle) .'</div>';
								if ($imageDesc) $slideshow_caption='<div class="slideshow_caption">'. $imageDesc .'</div>';

								echo '<div class="photowall-item photowall-item-presence photowall-item-not-visible '.$animation_class.'">';
								echo '<div class="photowall-item-inner">';

								$link_active = false;
								if ($photowall_type=="customlinks") {
									$link_text = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_link', true );
									$link_url = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_url', true );
									if (isSet($link_url) && $link_url<>"") {
										echo '<a href="'.esc_url($link_url).'" data-title="'.esc_attr($imageTitle).'">';
										$link_active = true;
									}
								} else {
									echo '<a data-src="'.esc_url($imageURI).'" href="'.esc_url($imageURI).'" data-title="'.esc_attr($imageTitle).'" class="lightbox-active lightbox-image" data-exthumbimage="'.esc_attr($thumb_imageURI).'">';
									$link_active = true;
								}
								
								echo kreativa_display_post_image (
									$post->ID,
									$have_image_url = $thumb_imageURI,
									$link =false,
									$type = "kreativa-gridblock-full",
									$title = $post->post_title,
									$class="photowall-image",
									$navigation=false
									);
								if ($slideshow_titledesc=="enable") {
									echo '<div class="photowall-content-wrap">';
									echo '<div class="photowall-box">';
									if ( $imageTitle || $imageDesc ) {

										if ($imageTitle) {
											echo '<div class="photowall-title"><span>' . $imageTitle . '</span></div>';
										}
										if ($imageDesc) {
											echo '<div class="photowall-desc"><span>' . $imageDesc . '</span></div>';
										}
										if ( $photowall_type == "customlinks" ) {
											if ( isSet($link_text) && $link_text<>"" ) {
												echo '<div class="photowall-button text-is-bright"><div class="mtheme-button">'.esc_html($link_text).'</div></div>';
											}
										}
									}
									echo '</div>';
									echo '</div>';
								}

								if ($link_active) {
									echo '</a>';
								}
								echo '</div>';
								echo '</div>';
							}
						}
					}
		// If Ends here for the Featured Page
				}
			}
			?>
		</div>
	</div>
	<?php
//End of Password Check
}
?>
<?php get_footer(); ?>