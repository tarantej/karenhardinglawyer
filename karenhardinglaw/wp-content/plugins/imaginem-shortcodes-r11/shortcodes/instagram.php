<?php
add_shortcode("insta_carousel", "mtheme_shortcode_scrape_instagram");
function mtheme_shortcode_scrape_instagram( $atts ) {
	extract(shortcode_atts(array(
		"username" => '',
		"instastyle" => 'grid',
		"token" => '',
		"slice" => '10',
		"count" => '7',
		"cache_renew" => '0',
		"columns" => '8'
	), $atts));

	if (isSet($token) && $token<>"") {
	    if ( false === ( $instagram = get_transient( 'instagram-media-mtheme-'.sanitize_title_with_dashes( $token ) ) ) && $cache_renew <> 1) {
		    $url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$token.'&count='.$count;
		    @$file_data = file_get_contents($url);
		    if (isSet($file_data)) {
		    	$jsonData = json_decode($file_data, true);
			}
			if (isSet($jsonData)) {
		    	$media_array = $jsonData['data'];
			}

			if ( isSet($media_array) && !empty( $media_array ) ) {
				$instagram = base64_encode( serialize( $media_array ) );
				set_transient( 'instagram-media-mtheme-'.sanitize_title_with_dashes( $token ), $instagram, apply_filters( 'null_instagram_cache_time', 24 * HOUR_IN_SECONDS ) );
			}
		} else {
			$media_array = unserialize( base64_decode( $instagram ) );
		}
	}

    // $result = '<ul>';
    // foreach ($data as $key => $value) {
    //     $result .= '<li><a href='.$value->link.' ><img src="'.$value->images->standard_resolution->url.'" width="70" height="70" /></a></li> ';
    // }
    // $result .= '</ul>';
    
    // echo '<pre>';
    // print_r($media_array);
    // echo '</pre>';

	if ( isSet($media_array) ) {

		$uniqureID=get_the_id()."-".uniqid();
		$insta_transition= imaginem_codepack_get_option_data('insta_transition');
		if ($insta_transition=="") {
			$insta_transition = 'fadeInOut';
		}
		if ($insta_transition=="false") {
			$insta_slideshow = 'false';
		} else {
			$insta_slideshow = 'true';
		}

		if ( $instastyle=="slideshow") {
			//$media_array = array_filter( $media_array, 'mtheme_images_only' );

			$insta_grid = '<ul id="owl-'.$uniqureID.'" class="owl-carousel instagram-photos">';
			// echo '<pre>';
			// print_r($media_array);
			// echo '</pre>';
			$count = 0;
			$target = '_blank';
			$aclass = 'instagram-photos-link';
			$imgclass = 'displayed-image';
			foreach ( $media_array as $item ) {
				$count++;
				$liclass="insta-image-".$count;
				$insta_grid .= '<li class="gridblock-grid-element '. $liclass .'">';
					$insta_grid .= '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $aclass .'">';

					$insta_grid .= '<img src="'. esc_url( $item['images']['standard_resolution']['url'] ) .'" alt="instagram" class="'. $imgclass .'"/>';
							$insta_grid .= '<div class="gridblock-background-hover">';
								$insta_grid .= '<div class="gridblock-links-wrap">';

									$insta_grid .= '<span class="column-gridblock-icon">';
										$insta_grid .= '<span class="hover-icon-effect">';
											$insta_grid .= '<i class="' . imaginem_codepack_get_portfolio_icon('link') . '"></i>';
										$insta_grid .= '</span>';
									$insta_grid .= '</span>';

								$insta_grid .= '</div>';
							$insta_grid .= '</div>';
					$insta_grid .= '</a>';
				$insta_grid .= '</li>';
			}
			$insta_grid .= '</ul>';
			$insta_grid .='
			<script>
			/* <![CDATA[ */
			(function($){
			$(window).load(function(){
				$("#owl-'.$uniqureID.'").owlCarousel({
				    responsive:{
				        0:{
				            items:1,
				            nav:true
				        },
				        400:{
				            items:1,
				            nav:true
				        },
				        600:{
				            items:3,
				            nav:true
				        },
				        800:{
				            items:4,
				            nav:true
				        },
				        1000:{
				            items:'.$columns.',
				            nav:true
				        }
				    },
					items: '.$columns.',
					nav : true,
					navText : ["",""],
					loop: true
				});
			})
			})(jQuery);
			/* ]]> */
			</script>
			';

		} else {

			$count = 0;
			$target = '_blank';
			$insta_grid_first = '';
			$aclass = 'instagram-photos-link';
			$imgclass = 'displayed-image';
			$insta_grid = '<div class="insta-grid-outer clearfix">';
			$insta_grid .= '<div class="insta-grid-wrap">';
			$insta_grid .= '<div id="'.esc_attr($uniqureID).'" data-id="'.esc_attr($uniqureID).'" data-transition="'.esc_attr($insta_transition).'" data-slideshow="'.esc_attr($insta_slideshow).'" class="ri-grid ri-grid-size-2">';
			$insta_grid .= '<ul>';
			foreach ( $media_array as $item ) {
				$count++;
				$liclass="insta-grid-image-".$count;
				if ($count < 4 ) {
					$insta_grid_first .= '<li class="gridblock-grid-element '. $liclass .'" style="background-image:url('. esc_url( $item['images']['standard_resolution']['url'] ) .'">';
						$insta_grid_first .= '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $aclass .'">';

						//$insta_grid_first .= '<img src="'. esc_url( $item['images']['standard_resolution']['url'] ) .'" alt="instagram" class="'. $imgclass .'"/>';
								$insta_grid_first .= '<div class="gridblock-background-hover">';
									$insta_grid_first .= '<div class="gridblock-links-wrap">';

									$insta_grid_first .= '</div>';
								$insta_grid_first .= '</div>';
						$insta_grid_first .= '</a>';
					$insta_grid_first .= '</li>';
				} else {

					$insta_grid .= '<li class="gridblock-grid-element '. $liclass .'">';
						$insta_grid .= '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $aclass .'">';

						$insta_grid .= '<img src="'. esc_url( $item['images']['standard_resolution']['url'] ) .'" alt="instagram" class="'. $imgclass .'"/>';
								$insta_grid .= '<div class="gridblock-background-hover">';
									$insta_grid .= '<div class="gridblock-links-wrap">';

									$insta_grid .= '</div>';
								$insta_grid .= '</div>';
						$insta_grid .= '</a>';
					$insta_grid .= '</li>';
				}
			}
			$insta_grid .= '</ul>';
			$insta_grid .= '</div>';
			$insta_grid .= '</div>';

			$insta_grid .= '<ul class="instagram-first-three">';
			$insta_grid .= $insta_grid_first;
			$insta_grid .= '</ul>';
			$insta_grid .= '</div>';
		}

	}
	if (isSet($insta_grid)) {
		return $insta_grid;
	} else {
		return false;
	}
}

function mtheme_images_only( $media_item ) {

	if ( $media_item['type'] == 'image' || $media_item['type'] == 'video' )
		return true;

	return false;
}
?>