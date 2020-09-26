<?php
/**
 * [mtheme_imageslideshow description]
 * @param  [type] $atts    [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function mtheme_swiperslides($atts, $content = null) {
	extract(shortcode_atts(array(
		"pageid" => '',
		"imagesize" => 'kreativa-gridblock-full',
		"pb_image_ids" => '',
		"lightbox" => 'true',
		"format" => '',
		"carousel_type" => 'swiper',
		"columns" => '4',
		"limit" => '-1',
		"pagination" => 'false'
	), $atts));

$uniqureID=get_the_id()."-".uniqid();

$column_type="four";
$portfolioImage_type=$imagesize;
$portfolioImage_type2="kreativa-gridblock-tiny";

$portfolio_count=0;
$flag_new_row=true;
$portfoliogrid='';
$portfoliogrid2='';

if ($carousel_type=="swiper") {
	
	if (trim($pb_image_ids)<>'' ) {
		$filter_image_ids = explode(',', $pb_image_ids);
	} else {
		if ( !isSet($pageid) || empty($pageid) || $pageid=='' ) {
			$pageid = get_the_id();
		}
		$filter_image_ids = imaginem_codepack_get_custom_attachments ( $pageid );
	}

	$lightbox_code = '';

	if ( $filter_image_ids ) {

		$uniqureID=get_the_id()."-".uniqid();

		$carousel = '<div id="'.$uniqureID.'" class="swiper-container shortcode-swiper-container" data-id="'.$uniqureID.'"">
	    <div class="swiper-wrapper">';

		foreach ( $filter_image_ids as $attachment_id) {

				//echo $type, $portfolio_type;
			$custom = get_post_custom(get_the_ID());
			$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
			$lightboxvideo="";
			$thumbnail="";
			$customlink_URL="";
			$portfolio_thumb_header="Image";

			$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
			$imageURI = $imagearray[0];
			
			$slideshow_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
			$slideshow_imageURI = $slideshow_imagearray[0];

			$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type2, false);
			$thumbnail_imageURI = $thumbnail_imagearray[0];

			if ( isSet($slideshow_imageURI) && !empty( $slideshow_imageURI ) ) {
				$portfolio_count++;

				if ($lightbox=="true") {
					$lightbox_code = imaginem_codepack_activate_lightbox (
						$lightbox_type="default",
						$ID=get_the_id(),
						$predefined=$imageURI,
						$mediatype="image",
						$imageTitle="",
						$class="swiper-slide-lightbox lightbox-image",
						$set="swiper-slide-set",
						$data_name="default",
						$external_thumbnail_id = $attachment_id,
						$imageDataID=$attachment_id
					);
					$lightbox_code .='</a>';
				}
		        $carousel .= '<div class="swiper-slide" style="background-image: url('.esc_url($imageURI).'); background-size: cover; background-position: 50% 0%;">'.$lightbox_code.'</div>';

			}

		}
		$carousel .='</div>';
	    if ($portfolio_count>4) {
		    $carousel .='<div class="swiper-pagination"></div>';
		    
		    $carousel .='<div class="swiper-button-prev"><i class="feather-icon-arrow-left"></i></div>';
		    $carousel .='<div class="swiper-button-next"><i class="feather-icon-arrow-right"></i></div>';
		}

		$carousel .='</div>';
    }
}

	return $carousel;
}
add_shortcode("swiperslides", "mtheme_swiperslides");
/**
 * AJAX Flexi Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_AJAXFelxiSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"pageid" => '1',
		"lightbox" => 'true',
		"lboxtitle" => 'true',
		"crop" => 'true',
		"height" => '434',
		"width" => '1020',
		"type" => 'Fill',
		"resize" => true,
		"title" => 'false'
	), $atts));
	$withplus=$width+20;
	$resize_image=false;
	if ($resize=="true") { $resize_image=true; }
	$quality=MTHEME_IMAGE_QUALITY;
	$link_end="";
	$lightbox_link="";
	$crop_image= " ,imageCrop: false";
	$lightbox_link = " ,lightbox: false";
	$portfolio_type= " ,lightbox: false ,imageCrop: true";
	
	if ($type=="Normal") $portfolio_type= " ,lightbox: false ,imageCrop: false";
	if ($type=="Fill") $portfolio_type= " ,lightbox: false ,imageCrop: true";
	if ($type=="Normal-plus-Lightbox") $portfolio_type= " ,lightbox: true ,imageCrop: false";
	if ($type=="Fill-plus-Lightbox") $portfolio_type= " ,lightbox: true ,imageCrop: true";
	
	//echo $type, $portfolio_type;
	//global $mtheme_thepostID;

	$flexID = "ID" . dechex(time()).dechex(mt_rand(1,65535));
	$filter_image_ids = imaginem_codepack_get_custom_attachments ( $pageid );						
	if ( $filter_image_ids ) 
	{
	$output = '
	<div class="spaced-wrap clearfix">
		<div class="flexslider-container-page flexislider-container1">
			<div id="flex1" class="flexslider">
			<ul class="slides">';
			foreach ( $filter_image_ids as $attachment_id) {
			$imagearray = wp_get_attachment_image_src( $attachment_id , 'kreativa-gridblock-full', false);
			$imageURI = $imagearray[0];
			$imageID = get_post($attachment_id);
			$imageTitle = $imageID->post_title;
			$imageCaption = $imageID->post_excerpt;

			$fullimagearray = wp_get_attachment_image_src( $attachment_id , '', false);
			$fullimageURI = $fullimagearray[0];

			if ($title=="false") { $imageTitle=""; }
			$output .= '<li>';

					$output .= mtheme_showimage (
						$imageURI,
						$link="",
						$resize=false,
						$height,
						$width,
						$quality=MTHEME_IMAGE_QUALITY, 
						$crop=1,
						$alt_text = imaginem_codepack_get_alt_text( $attachment_id ),
						$class=""
						);
			if ($lightbox=='true') {
				if ($lboxtitle=='true') $lightboxTitle = 'title="'.$imageTitle.'" ';
				$output .= '<div class="lightbox-toggle"><a class="gridblock-image-link flexislideshow-link" '. $lightboxTitle .'data-lightbox="magnific-image-gallery" href="'.$fullimageURI.'">';
					$output .= '<i class="feather-icon-maximize"></i>';
				$output .= '</a></div>';
			}
			
			$output .='</li>';
			}
		$output .='</ul></div></div></div>';
	return $output;
	}	
}
add_shortcode("ajaxflexislideshow", "mtheme_AJAXFelxiSlideshow");
/**
 * Blog Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_BlogSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"cat_slug" => '',
		"lightbox" => 'true',
		"autoplay" => 'false',
		"transition" => 'fade',
		"limit" => ''
	), $atts));
	
	//echo $type, $portfolio_type;
	query_posts(array(
		'category_name' => $cat_slug,
		'posts_per_page' => $limit
		));

	$uniqureID=get_the_id()."-".uniqid();

	$portfolioImage_type="kreativa-gridblock-full";

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-blog-slideshow clearfix">';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			if ( has_post_thumbnail() ) {
				$output .= '<li class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				$lightbox_image = imaginem_codepack_featured_image_link( get_the_id() );

				$lightbox_media = $lightbox_image;

				$custom = get_post_custom(get_the_ID());

				if ( isset($custom['pagemeta_lightbox_video'][0]) ) { 
					$lightbox_media=$custom['pagemeta_lightbox_video'][0];
				}
				// Large image sequence
				if ($lightbox=="true") {
					$output .= imaginem_codepack_activate_lightbox (
						$lightbox_type="default",
						$ID=get_the_id(),
						$predefined=$lightbox_media,
						$mediatype="image",
						$imagetitle=get_the_title(),
						$class="lightbox-image",
						$set="blog-slideshow-lightbox-set",
						$data_name="default",
                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                        $imageDataID=get_post_thumbnail_id( get_the_id() )
					);
				}

				$output .= imaginem_codepack_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$theimage_type=$portfolioImage_type,
					$imagetitle='',
					$class="displayed-image"
				);
				$output .= '</a>';
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title"><h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2></div>';

				$output .= '<div class="slideshow-box-info">';
					$output .='<div class="slideshow-box-categories">';
					foreach((get_the_category()) as $category) { 
					    $output .= '<span>'.$category->cat_name.'</span>';
					} 
					$output .='</div>';
					$category = get_the_category();
					$output .= '<div class="slideshow-box-comment">';

					$num_comments = get_comments_number( get_the_id() ); // get_comments_number returns only a numeric value
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments_desc = __('0 <i class="feather-icon-speech-bubble"></i>');
						} elseif ( $num_comments > 1 ) {
							$comments_desc = $num_comments . __(' <i class="feather-icon-speech-bubble"></i>');
						} else {
							$comments_desc = __('1 <i class="feather-icon-speech-bubble"></i>');
						}
						$output .= '<a href="' . get_comments_link( get_the_id() ) .'">'. $comments_desc.'</a>';
					}
					$output .='</div>';
					$output .='<div class="slideshow-box-date"><i class="feather-icon-clock"></i> '.get_the_date('jS M y').'</div>';
				$output .='</div>';

				$output .= '</div>';
				$output .= '</div>';
				$output .='</li>';
			}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.$uniqureID.'");
		 sync1.owlCarousel({
			items: 1,
			autoplay: '.$autoplay.',
			nav: true,
			autoHeight : true,
			loop: true,
			navText : ["",""],
			singleItem : true,
			animateOut: "fadeOut"
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';

	
	wp_reset_query();
	return $output;
	
}
add_shortcode("recent_blog_slideshow", "mtheme_BlogSlideshow");


/**
 * Portfolio Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_PortfolioSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"lazyload" => 'false',
		"transition" => 'fade'
	), $atts));

	if ($limit=='') {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;
	$countquery = array(
		'post_type' => 'mtheme_portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'types' => $worktype_slugs,
		'posts_per_page' => $limit,
		);
	query_posts($countquery);

	$portfolioImage_type="kreativa-gridblock-full";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	if ($lazyload=="true") {
		$class_status = "owl-lazy";
	} else {
		$class_status = "owl-slide-image";
	}
	$output = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			if ( has_post_thumbnail() ) {
				$output .= '<li class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				$lightbox_image = imaginem_codepack_featured_image_link( get_the_id() );

				$lightbox_media = $lightbox_image;

				$custom = get_post_custom(get_the_ID());

				if ( isset($custom['pagemeta_lightbox_video'][0]) ) { 
					$lightbox_media=$custom['pagemeta_lightbox_video'][0];
				}
				
				$output .= '<a class="gridblock-image-link flexislideshow-link"' .' title="'.get_the_title().'" data-lightbox="magnific-image-gallery" href="'.$lightbox_media.'">';

				$image_id = get_post_thumbnail_id( get_the_ID() , $portfolioImage_type); 
				$image_url = wp_get_attachment_image_src($image_id,$portfolioImage_type);  
				$image_url = $image_url[0];
				$img_obj = get_post($image_id);
				$img_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

				$output .= imaginem_codepack_display_post_image (
					get_the_id(),
					$have_image_url=$image_url,
					$link=false,
					$type=$portfolioImage_type,
					$imagetitle=get_the_title(),
					$class= $class_status,
					$lazyload_status = $lazyload
				);

				$output .= '</a>';
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';

			$output .= '<div class="slideshow-box-info">';
				$output .='<div class="slideshow-box-categories">';
				$categories = get_the_term_list( get_the_id(), 'types', '', ' / ', '' );
				    $output .= '<span>'.$categories.'</span>';
				$output .='</div>';
			$output .='</div>';

				$output .= '</div></div>';
				$output .='</li>';
			}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.$uniqureID.'");
		 sync1.owlCarousel({
			items: 1,
			autoplay: '.$autoplay.',
			lazyLoad: '.$lazyload.',
			nav: true,
			autoHeight : true,
			loop: true,
			navText : ["",""],
			singleItem : true,
			animateOut: "fadeOut"
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';

	
	wp_reset_query();
	return $output;


}
add_shortcode("recent_portfolio_slideshow", "mtheme_PortfolioSlideshow");

/**
 * [mtheme_imageslideshow description]
 * @param  [type] $atts    [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function mtheme_imageslideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"windowtype" => '',
		"pageid" => '',
		"imagesize" => 'kreativa-gridblock-full',
		"pb_image_ids" => '',
		"slideshowtype" => 'slideshow',
		"autoplay" => 'false',
		"thumbnails" => 'true',
		"lazyload" => 'false',
		"lightbox" => 'true',
		"format" => '',
		"carousel_type" => 'owl',
		"columns" => '4',
		"limit" => '-1',
		"displaytitle" => 'false',
		"desc" => 'true',
		"height" => '',
		"boxtitle" => 'true',
		"worktype_slug" => '',
		"pagination" => 'false'
	), $atts));

$uniqureID=get_the_id()."-".uniqid();

if ($windowtype=="ajax") {
	$uniqureID = "ajax";
}
if ($autoplay <> "true") {
	$autoplay="false";
}
$column_type="four";
$portfolioImage_type=$imagesize;
$portfolioImage_type2="kreativa-gridblock-tiny";

if ($worktype_slug=="-1") { $worktype_slug=''; }
$portfolio_count=0;
$flag_new_row=true;
$portfoliogrid='';
$portfoliogrid2='';

if ($windowtype=="ajax") {
	$lightbox = "false";
}
if ($carousel_type=="owl") {

	$portfoliogrid_line1 = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$portfoliogrid_line2 = '<div id="'.$uniqureID.'" class="owl-carousel owl-slideshow-element owl-carousel-detect owl-carousel-type-'.$slideshowtype.'" data-id="'.$uniqureID.'" data-autoplay="'.$autoplay.'" data-lazyload="'.$lazyload.'" data-type="'.$slideshowtype.'">';
	
	if (trim($pb_image_ids)<>'' ) {
		$filter_image_ids = explode(',', $pb_image_ids);
	} else {
		if ( !isSet($pageid) || empty($pageid) || $pageid=='' ) {
			$pageid = get_the_id();
		}
		$filter_image_ids = imaginem_codepack_get_custom_attachments ( $pageid );
	}

	if ($lazyload=="true") {
		$class_status = "owl-lazy";
	} else {
		$class_status = "owl-slide-image";
	}

	if ( $filter_image_ids ) {
		foreach ( $filter_image_ids as $attachment_id) {

				//echo $type, $portfolio_type;
			$custom = get_post_custom(get_the_ID());
			$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
			$lightboxvideo="";
			$thumbnail="";
			$customlink_URL="";
			$portfolio_thumb_header="Image";

			$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
			$imageURI = $imagearray[0];			
			
			$slideshow_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
			$slideshow_imageURI = $slideshow_imagearray[0];

			$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type2, false);
			$thumbnail_imageURI = $thumbnail_imagearray[0];

			if ($portfolio_count==$columns) $portfolio_count=0;

			if ( isSet($slideshow_imageURI) && !empty( $slideshow_imageURI ) ) {

				$imageID = get_post($attachment_id);
				$imageTitle = $imageID->post_title;
				$imageDesc= $imageID->post_content;

				$protected="";
				$icon_class="column-gridblock-icon";
				$portfolio_count++;
				$portfoliogrid .= '<div class="gridblock-slideshow-element">';

				// Large image sequence
				if ($lightbox=="true") {
					$portfoliogrid .= imaginem_codepack_activate_lightbox (
						$lightbox_type="default",
						$ID=get_the_id(),
						$predefined=$imageURI,
						$mediatype="image",
						$imagetitle=$imageTitle,
						$class="lightbox-image",
						$set="owlslideshow-lightbox-set",
						$data_name="default",
						$external_thumbnail_id = $attachment_id,
						$imageDataID=$attachment_id
					);
				}

					$portfoliogrid .= imaginem_codepack_display_post_image (
						$attachment_id,
						$have_image_url=$slideshow_imageURI,
						$link=false,
						$type=$portfolioImage_type,
						$imagetitle=$imageTitle,
						$class= $class_status,
						$lazyload_status = $lazyload
					);
				if ($lightbox=="true") {
					$portfoliogrid .= '</a>';
				}
					if ($displaytitle=='true') {
						$portfoliogrid .= '<div class="slideshow-owl-title">'.$imageTitle.'</div>';
					}

				$portfoliogrid .='</div>';

			}

		}
	}
	$portfoliogrid .='</div>';
}

	$portfoliogrid .='</div>';
	if ($windowtype=="ajax") {
		$portfoliogrid_script='';
	}

	$slideshow_1 = $portfoliogrid_line1 . $portfoliogrid_line2 . $portfoliogrid;

	return $slideshow_1;
}
add_shortcode("slideshowcarousel", "mtheme_imageslideshow");

//Recent Works Carousel
function mtheme_fotorama($atts, $content = null) {
	extract(shortcode_atts(array(
		"filltype" => 'cover',
		"transition" => 'crossfade',
		"autoplay" => 'true',
		"hash" => 'false',
		"pagetitle" => "false",
		"titledesc" => "enable",
		"titles" => "enable",
		"pageid" => '',
		"pb_image_ids" => '',
		"thumbnails" => 'true',
		"displaytitle" => 'false',
		"desc" => 'true',
		"worktype_slug" => ''
	), $atts));

$uniqureID=get_the_id()."-".uniqid();
$column_type="four";
$portfolioImage_type="kreativa-gridblock-full";
$portfolioImage_type2="kreativa-gridblock-large";

if ($worktype_slug=="-1") { $worktype_slug=''; }
$portfolio_count=0;
$flag_new_row=true;
$portfoliogrid='';
$portfoliogrid2='';


$fotorama = '<div class="mtheme-fotorama">';
$fotorama .= '<div class="fotorama"
 data-fit="'.$filltype.'"
 data-nav="thumbs"
 data-shuffle="false"
 data-loop="true"
 data-thumbwidth="40"
 data-thumbheight="40"
 data-keyboard="true"
 data-hash="'.$hash.'"
 data-transition="'.$transition.'"
 data-transition-duration="800"
 data-autoplay="6000"
 data-auto="false"
 >';
	
	if (trim($pb_image_ids)<>'' ) {
		$filter_image_ids = explode(',', $pb_image_ids);
	} else {
		if ( !isSet($pageid) || empty($pageid) || $pageid=='' ) {
			$pageid = get_the_id();
		}
		$filter_image_ids = imaginem_codepack_get_custom_attachments ( $pageid );
	}

	if ( $filter_image_ids ) {
		foreach ( $filter_image_ids as $attachment_id) {

				//echo $type, $portfolio_type;
			$custom = get_post_custom(get_the_ID());
			$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
			$lightboxvideo="";
			$thumbnail="";
			$customlink_URL="";
			$portfolio_thumb_header="Image";

			$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
			$imageURI = $imagearray[0];

			$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , 'kreativa-gridblock-tiny', false);
			$thumbnail_imageURI = $thumbnail_imagearray[0];

			if ( isSet($imageURI) && !empty( $imageURI ) ) {

				$imageID = get_post($attachment_id);
				$imageTitle = $imageID->post_title;
				$imageDesc= $imageID->post_content;
				if ($titles<>"enable") {
					$imageTitle='';
				}
				$displaypagetitle='';
				if ($pagetitle=="true") {
					$displaypagetitle= '<h1>'.get_the_title().'</h1>';
				}

				$title_desc='';
				if ($titledesc=="enable") {
					$title_desc = 'data-caption="'.$displaypagetitle.'<h2>'.$imageTitle.'</h2>';
					if ($imageDesc<>""){
						$title_desc .= '<p>'.esc_html($imageDesc).'</p>';
					}
					$title_desc .= '" '; 
				}

				$fotorama .= '<a '.$title_desc.'href="'.$imageURI.'">';
				$fotorama .= '<img src="'.esc_url($thumbnail_imageURI).'" alt="'.esc_attr($imageTitle).'" />';
				$fotorama .= '</a>';
			}

		}
	}
	
	$fotorama .='</div>';
	$fotorama .='</div>';

	return $fotorama;
}
add_shortcode("fotorama", "mtheme_fotorama");
?>