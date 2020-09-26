<?php
// Before After
if (!function_exists('mtheme_BeforeAfter')) {
    function mtheme_BeforeAfter($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "urls" => '',
            "url1" => '',
            "url2" => '',
            "format" => 'vertical',
            "pb_image_ids" => ''
        ), $atts));
        
        $uniqueID           = uniqid();
        $before_after_count = 0;
        $before_after_url   = array();
        
        if ($urls == "attachment_images") {
            
            $filter_image_ids = imaginem_codepack_get_custom_attachments(get_the_id());
            
            foreach ($filter_image_ids as $attachment_id) {
                
                $imagearray = wp_get_attachment_image_src($attachment_id, 'kreativa-gridblock-full', false);
                $imageURI   = $imagearray[0];
                
                if (isSet($imageURI)) {
                    
                    $before_after_url[$before_after_count] = $imageURI;
                    $before_after_count++;
                    
                }
                
                if ($before_after_count == 2) {
                    break;
                }
            }
            
            $url1 = $before_after_url[0];
            $url2 = $before_after_url[1];
            
        }
        
        $beforeafter = '<div id="before-after-id-' . $uniqueID . '" class="before-after-shortcode before-after-container" data-orientation="vertical">';
        $beforeafter .= '<div class="twentytwenty-container">';
        $beforeafter .= '<img src="' . $url1 . '" alt="before" />';
        $beforeafter .= '<img src="' . $url2 . '" alt="after"/>';
        $beforeafter .= '</div>';
        $beforeafter .= '</div>';
        
        $beforeafter .= '
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		$("#before-after-id-' . $uniqueID . '").twentytwenty({default_offset_pct: 0.5});
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
        
        return $beforeafter;
        
    }
}
add_shortcode("beforeafter", "mtheme_BeforeAfter");

//Metro Gallery [metro]
if (!function_exists('mtheme_MetroGrids')) {
    function mtheme_MetroGrids($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "size" => 'thumbnail',
            "exclude_featured" => 'false',
            "format" => '',
            "edgetoedge" => 'false',
            "start" => '',
            "animated" => 'false',
            "end" => '',
            "pb_image_ids" => '',
            "columns" => '4',
            "title" => "false",
            "description" => "false",
            "id" => '1',
            "pageid" => ''
        ), $atts));
        
        // Set a default
        $animation_class = '';
        if ($animated == "true") {
            $animation_class = ' grid-animate-display-all';
        }
        
        $portfolio_count = 0;
        $thumbnailcount  = 0;
        if ($pageid != '') {
            $thepageID = get_the_id();
        }
        
        if (trim($pb_image_ids) <> '') {
            $filter_image_ids = explode(',', $pb_image_ids);
        } else {
            $filter_image_ids = imaginem_codepack_get_custom_attachments($pageid);
        }
        
        if ($end < $start) {
            $end   = '';
            $start = '';
        }
        
        $uniqureID = get_the_id() . "-" . uniqid();
        
        if ($filter_image_ids) {
            
            $thumbnails = '<div class="gridblock-metro-wrap gridblock-metro-wrap-' . $uniqureID . ' clearfix">';
            $thumbnails .= '<div class="gridblock-metro">';
            
            $featuredID = get_post_thumbnail_id();
            
            foreach ($filter_image_ids as $attachment_id) {

                $check_if_image_present = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                //print_r($check_if_image_present); echo '------'.$attachment_id.'<br/>';
                if ( !$check_if_image_present ) {
                    continue;
                }
                
                $thumbnailcount++;
                
                if ($start != '') {
                    if ($thumbnailcount < $start) {
                        continue;
                    }
                }
                if ($end != '') {
                    if ($thumbnailcount > $end) {
                        continue;
                    }
                }
                
                if ($exclude_featured == 'true') {
                    if ($featuredID == $attachment_id)
                        continue; // skip rest of the loop
                }
                
                $imagearray = wp_get_attachment_image_src($attachment_id, 'kreativa-gridblock-full', false);
                $imageURI   = $imagearray[0];
                
                $thumbnail_imagearray = wp_get_attachment_image_src($attachment_id, 'kreativa-gridblock-square-big', false);
                $thumbnail_imageURI   = $thumbnail_imagearray[0];
                
                $bigthumbnail_imagearray = wp_get_attachment_image_src($attachment_id, 'kreativa-gridblock-square-big', false);
                $bigthumbnail_imageURI   = $bigthumbnail_imagearray[0];
                
                $imageID = get_post($attachment_id);
                
                $imageTitle = '';
                $imageDesc  = '';
                if (isSet($imageID->post_title)) {
                    $imageTitle = $imageID->post_title;
                }
                if (isSet($imageID->post_content)) {
                    $imageDesc = $imageID->post_content;
                }
                
                $portfolio_count++;
                
                $cell_name = "following-cell";
                if ($portfolio_count == 1) {
                    $cell_name          = "first-cell";
                    $thumbnail_imageURI = $bigthumbnail_imageURI;
                }
                
                // if ($portfolio_count==1) {
                // 	$thumbnails .=   '<li class="clearfix"></li>';
                // }
                
                $thumbnails .= '<div class="gridblock-element ' . $animation_class . ' gridblock-col-' . $portfolio_count . ' gridblock-cell-' . $cell_name . '">';
                
                $thumbnails .= '<div class="gridblock-grid-element gridblock-element-inner" data-rel="' . get_the_id() . '">';
                $thumbnails .= imaginem_codepack_activate_lightbox(
                    $lightbox_type = "default",
                    $ID = get_the_id(),
                    $predefined = $imageURI,
                    $mediatype = "image",
                    $title = $imageTitle,
                    $class = "column-gridblock-lightbox lightbox-image",
                    $set = "metro-grid",
                    $data_name = "default",
                    $external_thumbnail_id = $attachment_id,
                    $imageDataID=$attachment_id
                );
                $thumbnails .= '<div class="gridblock-background-hover">';
                $thumbnails .= '<div class="gridblock-links-wrap">';
                
                
                $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                
                
                
                $thumbnails .= '</div>';
                $thumbnails .= '</div>';
                
                $thumbnails .= '<img class="preload-image displayed-image" src="' . $thumbnail_imageURI . '" alt="' . imaginem_codepack_get_alt_text($featuredID) . '">';
                $thumbnails .= '</a>';
                $thumbnails .= '</div>';
                $thumbnails .= '</div>';
            }
            $thumbnails .= '</div>';
            $thumbnails .= '</div>';
            
            return $thumbnails;
            
        }
    }
}
add_shortcode("metrogrid", "mtheme_MetroGrids");
//Thumbnails for Gallery [thumbnails]
if (!function_exists('mtheme_Thumbnails')) {
    function mtheme_Thumbnails($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "size" => 'thumbnail',
            "exclude_featured" => 'false',
            "attachment_linking" => 'false',
            "style" => 'classic',
            "filter" => '',
            "effect" => 'default',
            "format" => '',
            "like" => 'no',
            "filterall" => 'All',
            "start" => '',
            "end" => '',
            "linktype" => 'lightbox',
            "animated" => 'true',
            "gutter" => 'spaced',
            "boxtitle" => '',
            "pb_image_ids" => '',
            "columns" => '4',
            "title" => "false",
            "description" => "false",
            "id" => '1',
            "pageid" => ''
        ), $atts));

        if ($effect=="{{effect}}") {
            $effect = "default";
        }

        $effect_class = ' has-effect-'.$effect;
        switch ($style) {
            case 'wall-spaced':
                $title = "false";
                $description = "false";
                $gutter = "spaced";
                break;
            
            case 'wall-grid':
                $title = "false";
                $description = "false";
                $gutter = "nospace";
                break;
            
            default:
                break;
        }

        if (!isSet($style)) {
            $style = "classic";
        }

        $animation_class = '';
        if ($style == "wall-spaced" || $style == "wall-grid" ) {
            $animation_class = ' grid-animate-display-all';
        }
        if ($animated == "true" && $style<>"wall-spaced" && $style<>"wall-grid" ) {
            $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
        }
        
        // Set a default
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $column_type         = "one";
            $portfolioImage_type = "kreativa-gridblock-full";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        $gridblock_is_masonary = "";
        if ($format == "masonary") {
            
            $gridblock_is_masonary = " gridblock-masonary";
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
        $preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="' . get_template_directory_uri() . $protected_placeholder . '" alt="preloading" /></div>';
        
        $portfolio_count = 0;
        $thumbnailcount  = 0;
        $thepageID       = get_the_id();
        
        $pb_image_ids = trim($pb_image_ids);
        if (!empty($pb_image_ids)) {
            $filter_image_ids = explode(',', $pb_image_ids);
        } else {
            if ($pageid == '') {
                $pageid = get_the_id();
            }
            $filter_image_ids = imaginem_codepack_get_custom_attachments($pageid);
        }
        
        if ($end < $start) {
            $end   = '';
            $start = '';
        }
        
        $thumbnail_gutter_class = '';
        if ($gutter == "nospace") {
            $thumbnail_gutter_class = ' thumnails-gutter-active ';
        }
        
        $title_desc_class = '';
        if ($title == "false" && $description == "false") {
            $title_desc_class = " no-title-no-desc";
        }
        $boxtitle_class = '';
        if ($boxtitle == "true") {
            $boxtitle_class = " boxtitle-active";
        }
        
        $filterable_tags = array();
        
        if ($filter_image_ids) {
            
            $thumbnails = '<div class="thumbnails-shortcode gridblock-columns-wrap grid-style-'.$style.'-wrap clearfix">';
            $thumbnails .= '<div class="thumbnails-grid-container grid-style-'.$style.' thumbnail-gutter-' . $gutter . $gridblock_is_masonary . $thumbnail_gutter_class . $title_desc_class . $boxtitle_class . ' gridblock-' . $column_type . ' '. $effect_class.'"  data-columns="' . $columns . '">';
            
            $featuredID = get_post_thumbnail_id();
            
            foreach ($filter_image_ids as $attachment_id) {
                

                $check_if_image_present = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                //print_r($check_if_image_present); echo '------'.$attachment_id.'<br/>';
                if ( !$check_if_image_present ) {
                    continue;
                }
                
                $thumbnailcount++;
                
                if ($start != '') {
                    if ($thumbnailcount < $start) {
                        continue;
                    }
                }
                if ($end != '') {
                    if ($thumbnailcount > $end) {
                        continue;
                    }
                }
                
                if ($exclude_featured == 'true') {
                    if ($featuredID == $attachment_id)
                        continue; // skip rest of the loop
                }
                
                $thumbnail_tags = get_the_terms($attachment_id, 'filtertag');
                
                $filter_attribute = '';
                // Build the filters
                if (isSet($thumbnail_tags) && is_array($thumbnail_tags)) {
                    foreach ($thumbnail_tags as $key => $value) {
                        $thumbnail_tag_slug                   = $value->slug;
                        $thumbnail_tag_name                   = $value->name;
                        $filter_attribute .=' filter-'.$thumbnail_tag_slug;
                        $filterable_tags[$thumbnail_tag_slug] = $thumbnail_tag_name;
                    }
                }

                $purchase_url = false;
                
                // echo '<pre>';
                // print_r($filterable_tags);
                // echo '</pre>';
                
                $imagearray = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                $imageURI   = $imagearray[0];
                
                $thumbnail_imagearray = wp_get_attachment_image_src($attachment_id, $portfolioImage_type, false);
                $thumbnail_imageURI   = $thumbnail_imagearray[0];
                
                $title_link = '';
                $imageTitle = '';
                $imageDesc  = '';
                $imageID    = get_post($attachment_id);
                $link_url   = get_post_meta($attachment_id, 'mtheme_attachment_fullscreen_url', true);
                $purchase_url   = get_post_meta($attachment_id, 'mtheme_attachment_purchase_url', true);

                if ( $purchase_url ) {
                    $purchase_link = $purchase_url;
                } else {
                    $purchase_link = false;
                }
                
                if (isSet($imageID->post_title)) {
                    $imageTitle = $imageID->post_title;
                }
                if (isSet($imageID->post_content)) {
                    $imageDesc = $imageID->post_content;
                }
                
                if ($portfolio_count == $columns)
                    $portfolio_count = 0;
                $portfolio_count++;
                
                // if ($portfolio_count==1) {
                // 	$thumbnails .=   '<li class="clearfix"></li>';
                // }
                $thumbnails .= '<div class="gridblock-element ' . $animation_class . ' isotope-displayed gridblock-thumbnail-id-' . $attachment_id . ' gridblock-col-' . $portfolio_count .$filter_attribute. '">';
                
                $thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="' . get_the_id() . '">';
                
                if (!isSet($linktype)) {
                    $linktype = "lightbox";
                }
                $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');

                if ($like == "yes") {
                    $thumbnails .= '<div class="mtheme-post-like-wrap">';
                    $thumbnails .= kreativa_display_like_link( $attachment_id );
                    $thumbnails .= '</div>';
                }
                
                $thumbnails .= '<div class="gridblock-background-hover">';

                $url_linked = false;
                
                if ($linktype == "download") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                    $thumbnails .= imaginem_codepack_activate_lightbox(
                        $lightbox_type = "default",
                        $ID = get_the_id(),
                        $predefined = $imageURI,
                        $mediatype = "image",
                        $imagetitletag = $imageTitle,
                        $class = "lightbox-image",
                        $set = "thumbnails-grid",
                        $data_name = "default",
                        $external_thumbnail_id = $attachment_id,
                        $imageDataID=$attachment_id
                        );
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                    $thumbnails .= '</a>';
                }
                
                if ($linktype == "lightbox") {
                    $thumbnails .= imaginem_codepack_activate_lightbox(
                        $lightbox_type = "default",
                        $ID = get_the_id(),
                        $predefined = $imageURI, $mediatype = "image",
                        $imagetitletag = $imageTitle,
                        $class = "lightbox-image gridblock-sole-link",
                        $set = "thumbnails-grid",
                        $data_name = "default",
                        $external_thumbnail_id = $attachment_id,
                        $imageDataID=$attachment_id
                    );
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');
                    $url_linked     = true;
                }
                if ($linktype == "url") {
                    if (isSet($link_url) && $link_url <> "") {
                        $thumbnails .= '<a class="gridblock-sole-link" href="' . esc_url($link_url) . '" data-title="' . esc_attr($imageTitle) . '">';
                        $thumbnail_icon = imaginem_codepack_get_portfolio_icon('link');
                        $url_linked     = true;
                        $title_link = $link_url;
                    } else {
                        $thumbnail_icon = '';
                    }
                }
                if ($linktype == "purchase") {
                    if (isSet($purchase_url) && $purchase_url <> "") {
                        $thumbnails .= '<a class="gridblock-sole-link" href="' . esc_url($purchase_url) . '" data-title="' . esc_attr($imageTitle) . '">';
                        $thumbnail_icon = imaginem_codepack_get_portfolio_icon('purchase');
                        $url_linked     = true;
                        $title_link = $purchase_url;
                    } else {
                        $thumbnail_icon = '';
                    }
                }
                if ($linktype == "download") {
                    $thumbnails .= '<a href="' . esc_url($imageURI) . '" data-title="' . esc_attr($imageTitle) . '" download>';
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('download');
                    $url_linked     = true;
                }
                
                if ($linktype != "download") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                }
                
                if ($attachment_linking == "true") {
                    $thumbnails .= '<a class="column-gridblock-icon" href="' . get_attachment_link($attachment_id) . '">';
                    $thumbnails .= '<span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i></span>';
                    $thumbnails .= '</a>';
                }
                
                if ($thumbnail_icon<>"") {
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . $thumbnail_icon . '"></i></span></span>';
                }
                
                if ($linktype != "download") {
                    $thumbnails .= '</div>';
                }

                if ($url_linked) {
                    $thumbnails .= '</a>';
                }
                if ($linktype == "download") {
                    $thumbnails .= '</div>';
                }
                if ($boxtitle == "true") {
                    $thumbnails .= '<span class="boxtitle-hover">';
                    $thumbnails .= '<span class="shortcode-box-title">';
                    $thumbnails .= $imageTitle;
                    $thumbnails .= '</span>';
                    $thumbnails .= '</span>';
                }
                $thumbnails .= '</div>';
                if ( isSet($thumbnail_imagearray[0]) && $thumbnail_imagearray[0]<>"" ) {
                    $thumbnails .= '<img class="preload-image displayed-image" src="' . $thumbnail_imagearray[0] . '" alt="' . imaginem_codepack_get_alt_text($featuredID) . '">';
                }
                
                $thumbnails .= '</div>';
                if ($title == "true" || $description == "true") {
                    $thumbnails .= '<div class="work-details">';
                    if ($title == 'true') {
                        $thumbnails .= '<h4>';
                        $thumbnails .= $imageTitle;
                        $thumbnails .= '</h4>';
                    }
                    if ($description == 'true') {
                        $thumbnails .= '<p class="entry-content work-description">' . $imageDesc . '</p>';
                    }
                    $thumbnails .= '</div>';
                }
                $thumbnails .= '</div>';
            }
            $thumbnails .= '</div>';
            $thumbnails .= '</div>';
            
            
            $filter_thumbnails = "";
            if ($filter == "tags") {
                
                $filter_thumbnails .= '<div class="gridblock-filter-select-wrap is-animated fadeIn animation-standby">';
                
                $filter_thumbnails .= '<div id="gridblock-filters">';
                $filter_thumbnails .= '<ul class="gridblock-filter-categories">';
                
                if ($filterall<>"{{filterall}}") {
                    $filter_tag_text  = $filterall;
                } else {
                    $filter_tag_text = "All";
                }
                $filter_thumbnails .= '<li class="filter-all-control">';
                $filter_thumbnails .= '<a data-filter="*" data-title="' . $filter_tag_text . '" href="#">';
                $filter_thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>' . $filter_tag_text;
                $filter_thumbnails .= '</a>';
                $filter_thumbnails .= '</li>';
                
                $categories = get_categories('orderby=slug&taxonomy=types&title_li=');

                $filter_seperator='';
                
                foreach ($filterable_tags as $key=>$value) {

                        $filter_thumbnails .= '<li class="filter-control filter-category-control filter-control-' . $key . '">';
                        $filter_thumbnails .= '<a data-filter=".filter-' . $key . '" data-title="' . $value . '" href="#">';
                        $filter_thumbnails .= '<span class="filter-seperator filter-seperator-main">' . $filter_seperator . '</span>' . $value;
                        $filter_thumbnails .= '</a>';
                        $filter_thumbnails .= '</li>';
                }
                
                $filter_thumbnails .= '</ul>';

                $filter_thumbnails .= '</div>';
                $filter_thumbnails .= '</div>';
                //End of If Filter
            }
            
            return $filter_thumbnails . $thumbnails;
            
        }
    }
}
add_shortcode("thumbnails", "mtheme_Thumbnails");
/**
 * Portfolio Grid
 */
if (!function_exists('mPortfolioGrids')) {
    function mPortfolioGrids($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "pageid" => '',
            "style" => 'classic',
            "format" => '',
            "effect" => 'default',
            "columns" => '4',
            "limit" => '-1',
            "like" => 'no',
            "filter_seperator" => '',
            "filter_subcats" => "false",
            "category_display" => "true",
            "gutter" => 'spaced',
            "boxtitle" => 'false',
            "title" => 'true',
            "desc" => 'true',
            "worktype_slugs" => '',
            "pagination" => 'false',
            "animated" => 'true',
            "type" => 'filter'
        ), $atts));

        if ($effect=="{{effect}}") {
            $effect = "default";
        }

        $effect_class = ' has-effect-'.$effect;
        
        $portfoliogrid               = '';
        $subcat_filter_portfoliogrid = '';

        switch ($style) {
            case 'wall-spaced':
                $boxtitle = "box-lightbox";
                $title = "false";
                $desc = "false";
                $gutter = "spaced";
                break;
            
            case 'wall-grid':
                $boxtitle = "box-lightbox";
                $title = "false";
                $desc = "false";
                $gutter = "nospace";
                break;
            
            default:
                break;
        }

        if (!isSet($style)) {
            $style = "classic";
        }
        
        $animation_class = '';
        if ($style == "wall-spaced" || $style == "wall-grid" ) {
            $animation_class = ' grid-animate-display-all';
        }
        if ($animated == "true" && $style<>"wall-spaced" && $style<>"wall-grid" ) {
            $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
        }

        // Set a default
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $column_type         = "one";
            $portfolioImage_type = "kreativa-gridblock-full";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        $gridblock_is_masonary = "";
        if ($format == "masonary") {
            
            $gridblock_is_masonary = "gridblock-masonary ";
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
            $animation_class = ' grid-animate-display-all';
        }
        
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
        //$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
        $thumbnail_gutter_class = 'portfolio-gutter-' . $gutter . ' ';
        if ($gutter == "nospace") {
            $thumbnail_gutter_class .= 'thumnails-gutter-active ';
        }
        if ($title <> "true" && $desc <> "true") {
            $thumbnail_gutter_class .= 'no-title-no-desc ';
        }

        $boxtitle_class = '';
        if ($boxtitle == "box-lightbox" || $boxtitle == "box-directlink") {
            $boxtitle_class = " boxtitle-active";
        }
        $flag_new_row = true;
        
        $portfoliogrid .= '<div class="portfolio-grid-container portfolio-gridblock-columns-wrap">';
        $portfoliogrid .= '<div id="gridblock-container" class="' . $thumbnail_gutter_class . $gridblock_is_masonary . $boxtitle_class . $effect_class.' grid-style-'.$style.' gridblock-' . $column_type . ' clearfix" data-columns="' . $columns . '">';
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        
        $count           = 0;
        $terms           = array();
        $work_slug_array = array();
        //echo $worktype_slugs;
        if ($worktype_slugs != "") {
            $type_explode = explode(",", $worktype_slugs);
            foreach ($type_explode as $work_slug) {
                $terms[] = $work_slug;
            }
            query_posts(array(
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
            ));
        } else {
            query_posts(array(
                'post_type' => 'mtheme_portfolio',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $limit
            ));
        }
        
        $idCount               = 1;
        $portfolio_count       = 0;
        $portfolio_total_count = 0;
        $portfoliofilters      = array();
        
        if (have_posts()):
            while (have_posts()):
                the_post();
                //echo $type, $portfolio_type;
                $custom                 = get_post_custom(get_the_ID());
                $portfolio_cats         = get_the_terms(get_the_ID(), 'types');
                $lightboxvideo          = "";
                $thumbnail              = "";
                $customlink_URL         = "";
                $description            = "";
                $portfolio_link_type    = "DirectURL";
                $portfolio_thumb_header = "Image";
                $the_only_link          = false;
                $the_protected_link     = false;
                
                if (isset($custom['pagemeta_thumbnail_linktype'][0])) {
                    $portfolio_link_type = $custom['pagemeta_thumbnail_linktype'][0];
                }
                if (isset($custom['pagemeta_lightbox_video'][0])) {
                    $lightboxvideo = $custom['pagemeta_lightbox_video'][0];
                }
                if (isset($custom['pagemeta_customthumbnail'][0])) {
                    $thumbnail = $custom['pagemeta_customthumbnail'][0];
                }
                if (isset($custom['pagemeta_thumbnail_desc'][0])) {
                    $description = $custom['pagemeta_thumbnail_desc'][0];
                }
                if (isset($custom['pagemeta_customlink'][0])) {
                    $customlink_URL = $custom['pagemeta_customlink'][0];
                }
                if (isset($custom['pagemeta_portfoliotype'][0])) {
                    $portfolio_thumb_header = $custom['pagemeta_portfoliotype'][0];
                }
                
                // if boxed title then link directly.
                if ($boxtitle == "box-directlink") {
                    $portfolio_link_type = "DirectURL";
                }
                if ($boxtitle == "box-lightbox") {
                    $portfolio_link_type = "Lightbox";
                }
                if ($boxtitle != "box-lightbox" && $boxtitle != "box-directlink") {
                    $boxtitle = false;
                }
                
                if ($portfolio_count == $columns)
                    $portfolio_count = 0;
                
                $add_space_class = '';
                if ($gutter != 'nospace') {
                    if ($title == 'false' && $desc == 'false') {
                        $add_space_class = 'gridblock-cell-bottom-space';
                    }
                }
                
                $protected  = "";
                $icon_class = "column-gridblock-icon";
                $portfolio_count++;
                $portfolio_total_count++;
                
                $gridblock_ajax_class = '';
                if ($type == 'ajax') {
                    $gridblock_ajax_class = "gridblock-ajax ";
                }

                $featured_image_id = get_post_thumbnail_id( get_the_id() );
                $featured_image_data = get_post($featured_image_id);
                $featuredimg_purchase_url = '';
                $featuredimg_title = '';
                $featuredimg_desc = '';
                $purchase_link = false;

                if (isSet($featured_image_data->post_title)) {
                    $featuredimg_title = $featured_image_data->post_title;
                }
                if (isSet($featured_image_data->post_content)) {
                    $featuredimg_desc = $featured_image_data->post_content;
                }

                $featuredimg_purchase_url   = get_post_meta( $featured_image_id, 'mtheme_attachment_purchase_url', true);

                if ( $featuredimg_purchase_url ) {
                    $purchase_link = $featuredimg_purchase_url;
                } else {
                    $purchase_link = false;
                }
                
                // Generate main DIV tag with portfolio information with filterable tags
                $portfoliogrid .= '<div class="gridblock-element' . $animation_class . ' isotope-displayed gridblock-element-id-' . get_the_ID() . ' gridblock-element-order-' . $portfolio_total_count . ' ' . $add_space_class . ' gridblock-filterable ';
                if (is_array($portfolio_cats)) {
                    foreach ($portfolio_cats as $taxonomy) {
                        $portfoliogrid .= 'filter-' . $taxonomy->slug . ' ';
                        if ($pagination == 'true') {
                            if (in_array($taxonomy->slug, $portfoliofilters)) {
                            } else {
                                $portfoliofilters[] = $taxonomy->slug;
                            }
                        }
                    }
                }
                $idCount++;
                $portfoliogrid .= '" data-portfolio="portfolio-' . get_the_ID() . '" data-id="id-' . $idCount . '">';

                $portfoliogrid .= '<div class="' . $gridblock_ajax_class . 'gridblock-grid-element gridblock-element-inner" data-portfolioid="' . get_the_id() . '">';
                
                if ($like == "yes") {
                    $portfoliogrid .= '<div class="mtheme-post-like-wrap">';
                    $portfoliogrid .= kreativa_display_like_link(get_the_id());
                    $portfoliogrid .= '</div>';
                }
                $portfoliogrid .= '<div class="gridblock-background-hover">';
                
                if (post_password_required()) {
                    $the_only_link       = true;
                    $the_protected_link  = true;
                    $portfolio_link_type = "DirectURL";
                    $protected           = " gridblock-protected";
                    $iconclass           = "";
                }
                
                
                //if Password Required
                
                //Make sure it's not a slideshow
                if ($type != "ajax") {
                    //Switch check for Linked Type
                    //Switch check for Linked Type
                    //
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    }
                    
                    if ($portfolio_link_type <> "") {
                        
                        if ($portfolio_link_type == "Lightbox_DirectURL") {
                            $portfoliogrid .= '<a class="column-gridblock-icon" href="' . get_permalink() . '">';
                            $portfoliogrid .= '<span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i></span>';
                            $portfoliogrid .= '</a>';
                        }
                        
                        
                        switch ($portfolio_link_type) {
                            case 'DirectURL':
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                                if (post_password_required()) {
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('locked') . '"></i>';
                                } else {
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                                }
                                break;
                            
                            case 'Customlink':
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . $customlink_URL . '">';
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('link') . '"></i>';
                                break;
                            
                            case 'Lightbox_DirectURL':
                                if ($lightboxvideo <> "") {
                                    $portfoliogrid .= imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default",
                                        $ID = get_the_id(),
                                        $predefined = $lightboxvideo,
                                        $mediatype = "video",
                                        $imagetitle = $featuredimg_title,
                                        $class = "column-gridblock-icon column-gridblock-lightbox lightbox-video",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                        );
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                                } else {
                                    $portfoliogrid .= imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default",
                                        $ID = get_the_id(),
                                        $predefined = imaginem_codepack_featured_image_link(get_the_ID()),
                                        $mediatype = "image",
                                        $imagetitle = $featuredimg_title,
                                        $class = "column-gridblock-icon column-gridblock-lightbox lightbox-image", $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                        );
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                                }
                                break;
                            case 'Lightbox':
                                $the_only_link = true;
                                if ($lightboxvideo <> "") {
                                    $portfoliogrid .= imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default",
                                        $ID = get_the_id(),
                                        $predefined = $lightboxvideo,
                                        $mediatype = "video",
                                        $imagetitle = $featuredimg_title,
                                        $class = "gridblock-sole-link column-gridblock-lightbox lightbox-video",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                        );
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                                } else {
                                    $portfoliogrid .= imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default", $ID = get_the_id(),
                                        $predefined = imaginem_codepack_featured_image_link(get_the_ID()),
                                        $mediatype = "image",
                                        $imagetitle = $featuredimg_title,
                                        $class = "gridblock-sole-link column-gridblock-lightbox lightbox-image",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                        );
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                                }
                                break;
                            default:
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                                break;
                        }
                        
                        if ($portfolio_link_type != "Lightbox_DirectURL") {
                            $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                        }
                        // if it is not boxed title
                        if (!$boxtitle) {
                            if (isSet($icon_class)) {
                                if ($the_only_link) {
                                    $portfoliogrid .= '<span class="column-gridblock-icon">';
                                }
                                $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                                if ($the_only_link) {
                                    $portfoliogrid .= '</span>';
                                }
                            }
                        }
                        if ($portfolio_link_type != "Lightbox_DirectURL") {
                            $portfoliogrid .= '</div>';
                        }
                        if ($boxtitle) {
                            $portfoliogrid .= '<div class="boxtitle-hover">';
                            $portfoliogrid .= '<h3>'.get_the_title().'</h3>';
                            $portfoliogrid .= '</div>';
                        }
                        $portfoliogrid .= '</a>';
                    }
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '</div>';
                    }
                    //$portfoliogrid .= '</span>';
                    // If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
                    // Custom Thumbnail
                    // If AJAX
                } else {
                    $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    $portfoliogrid .= '<span class="column-gridblock-icon">';
                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('ajax') . '"></i>';
                    $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                    $portfoliogrid .= '</span>';
                    $portfoliogrid .= '</div>';
                }
                
                $portfoliogrid .= '</div>';
                
                $fade_in_class = "";
                if ($thumbnail <> "") {
                    $portfoliogrid .= '<img src="' . $thumbnail . '" class="' . $fade_in_class . 'displayed-image" alt="thumbnail" />';
                } else {
                    // Slideshow then generate slideshow shortcode
                    $portfoliogrid .= imaginem_codepack_display_post_image(get_the_ID(), $have_image_url = "", $link = false, $imagetype = $portfolioImage_type, $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = $fade_in_class . "displayed-image", $lazyload=false);
                    
                }
                $portfoliogrid .= '</div>';
                if ($title == 'true' || $desc == 'true') {
                    $portfoliogrid .= '<div class="work-details">';
                    $hreflink = get_permalink();
                    if ($category_display == 'true') {
                        $current_terms    = wp_get_object_terms(get_the_ID(), 'types');
                        $current_worktype = '';
                        $seperator        = ' , ';
                        foreach ($current_terms as $the_term) {
                            if ($the_term === end($current_terms)) {
                                $seperator = '';
                            }
                            $current_worktype .= $the_term->name . $seperator;
                        }
                        
                        $portfoliogrid .= '<div class="worktype-categories">' . $current_worktype . '</div>';
                    }
                    if ($title == 'true') {
                        if ($type != "ajax") {
                            $portfoliogrid .= '<h4><a href="' . $hreflink . '">' . get_the_title() . '</a></h4>';
                        } else {
                            $portfoliogrid .= '<h4>';
                            $portfoliogrid .= get_the_title();
                            $portfoliogrid .= '</h4>';
                        }
                    }
                    if ($desc == 'true') {
                        $portfoliogrid .= '<p class="entry-content work-description">' . $description . '</p>';
                    }

                    $portfoliogrid .= '</div>';
                }
                
                
                $portfoliogrid .= '</div>';
            //if ($portfolio_count==$columns)  $portfoliogrid .='</div>';
            endwhile;
        endif;
        // if ($format=="masonary") {
        // 	$portfoliogrid .= '</div>';
        // }
        $portfoliogrid .= '</div>';
        
        if ($pagination == 'true') {
            $portfolio_pagination = imaginem_codepack_pagination();
            if ($portfolio_pagination<>"") {
                $portfoliogrid .= '<div class="clearfix">';
                $portfoliogrid .= $portfolio_pagination;
                $portfoliogrid .= '</div>';
            }
        }
        $portfoliogrid .= '</div>';
        
        wp_reset_query();
        
        if ($type == "filter" || $type == "ajax") {
            
            $filter_portfoliogrid = "";
            
            $countquery = array(
                'post_type' => 'mtheme_portfolio',
                'types' => $worktype_slugs,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'posts_per_page' => -1
            );
            query_posts($countquery);
            if (have_posts()):
                while (have_posts()):
                    the_post();
                endwhile;
            endif;
            
            if ($type == "ajax") {
                $filter_portfoliogrid .= '	<div class="ajax-gridblock-block-wrap clearfix">';
                $filter_portfoliogrid .= '	<div class="ajax-gallery-navigation clearfix">';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-next" href="#"><i class="feather-icon-arrow-right"></i></a>';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-hide" href="#"><i class="feather-icon-align-justify"></i></a>';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-prev" href="#"><i class="feather-icon-arrow-left"></i></a>';
                $filter_portfoliogrid .= '		<span class="ajax-loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></span>';
                $filter_portfoliogrid .= '	</div>';
                $filter_portfoliogrid .= '	<div class="ajax-gridblock-window">';
                $filter_portfoliogrid .= '		<div id="ajax-gridblock-wrap"></div>';
                $filter_portfoliogrid .= '	</div>';
                $filter_portfoliogrid .= '	</div>';
            }
            $filter_portfoliogrid .= '<div class="gridblock-filter-select-wrap">';
            
            $filter_portfoliogrid .= '<div id="gridblock-filters">';
            $filter_portfoliogrid .= '<ul class="gridblock-filter-categories">';
            
            $filter_portfoliogrid .= '<li class="filter-all-control">';
            $filter_portfoliogrid .= '<a data-filter="*" data-title="' . imaginem_codepack_get_option_data('portfolio_allitems') . '" href="#">';
            $filter_portfoliogrid .= '<span class="filter-seperator filter-seperator-all"></span>' . imaginem_codepack_get_option_data('portfolio_allitems');
            $filter_portfoliogrid .= '</a>';
            $filter_portfoliogrid .= '</li>';
            
            //$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
            if ($worktype_slugs != '')
                $all_works = explode(",", $worktype_slugs);
            if ($filter_subcats == "true") {
                $categories = get_categories('orderby=slug&parent=0&taxonomy=types&title_li=');
            } else {
                $categories = get_categories('orderby=slug&taxonomy=types&title_li=');
            }
            foreach ($categories as $category) {
                
                $taxonomy = "types";
                
                // Using Term Slug
                $term_slug = $category->slug;
                $term      = get_term_by('slug', $term_slug, $taxonomy);
                
                // Enter only if Works is not set - means all included OR if work types are defined in shortcode
                if (!isSet($all_works) || in_array($term_slug, $all_works)) {
                    // Fetch the count
                    //echo $term->count;
                    if ($pagination == 'true') {
                        if (is_array($portfoliofilters)) {
                            $filter_found = false;
                            $hide_filter  = '';
                            if (in_array($category->slug, $portfoliofilters)) {
                                $filter_found = true;
                            }
                            
                        }
                        if (!$filter_found) {
                            $hide_filter = 'style="display:none;"';
                            //echo $category->slug;
                        }
                    }
                    $filter_portfoliogrid .= '<li ' . $hide_filter . ' class="filter-control filter-category-control filter-control-' . $category->slug . '">';
                    $filter_portfoliogrid .= '<a data-filter=".filter-' . $category->slug . '" data-title="' . $category->name . '" href="#">';
                    $filter_portfoliogrid .= '<span class="filter-seperator filter-seperator-main">' . $filter_seperator . '</span>' . $category->name;
                    $filter_portfoliogrid .= '</a>';
                    $filter_portfoliogrid .= '</li>';
                    
                    // Populate Subcategories
                    if ($filter_subcats == "true") {
                        $portfolio_subcategories = get_categories('orderby=slug&taxonomy=types&child_of=' . $category->term_id . '&title_li=');
                        //print_r($portfolio_subcategories);
                        
                        foreach ($portfolio_subcategories as $portfolio_subcategory) {
                            //print_r($portfolio_subcategory->slug);
                            $sub_filter_seperator = '';
                            $subcat_filter_portfoliogrid .= '<li class="filter-' . $category->slug . '-of-parent filter-subcat-control filter-control filter-control-' . $portfolio_subcategory->slug . '">';
                            $subcat_filter_portfoliogrid .= '<a data-filter=".filter-' . $portfolio_subcategory->slug . '" data-title="' . $portfolio_subcategory->name . '" href="#">';
                            $subcat_filter_portfoliogrid .= '<span class="filter-seperator filter-seperator-sub">' . $sub_filter_seperator . '</span>' . $portfolio_subcategory->name;
                            $subcat_filter_portfoliogrid .= '</a>';
                            $subcat_filter_portfoliogrid .= '</li>';
                        }
                    }
                }
            }
            
            $filter_portfoliogrid .= '</ul>';
            
            if ($subcat_filter_portfoliogrid <> '' && $filter_subcats == "true") {
                $subcat_filter_portfoliogrid = '<ul class="griblock-filters-subcats">' . $subcat_filter_portfoliogrid . '</ul>';
            }
            $filter_portfoliogrid .= $subcat_filter_portfoliogrid;
            $filter_portfoliogrid .= '</div>';
            $filter_portfoliogrid .= '</div>';
            //End of If Filter
        }
        
        if (isSet($filter_portfoliogrid)) {
            $portfoliogrid = $filter_portfoliogrid . $portfoliogrid;
        }
        //Reset query after Filters
        
        wp_reset_query();
        return $portfoliogrid;
    }
}
add_shortcode("portfoliogrid", "mPortfolioGrids");


//Recent Works Carousel
if (!function_exists('mLightboxCarousel')) {
    function mLightboxCarousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "pageid" => '',
            "pb_image_ids" => '',
            "format" => '',
            "carousel_type" => 'owl',
            "columns" => '4',
            "limit" => '-1',
            "title" => 'true',
            "desc" => 'true',
            "boxtitle" => 'true',
            "worktype_slug" => '',
            "pagination" => 'false'
        ), $atts));
        
        $uniqureID           = get_the_id() . "-" . uniqid();
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        
        if ($worktype_slug == "-1") {
            $worktype_slug = '';
        }
        $portfolio_count = 0;
        $flag_new_row    = true;
        $portfoliogrid   = '';
        
        if ($carousel_type == "owl") {
            
            $portfoliogrid .= '<div class="gridblock-owlcarousel-wrap clearfix">';
            $portfoliogrid .= '<div id="owl-' . $uniqureID . '" class="owl-carousel">';
            
            if (trim($pb_image_ids) <> '') {
                $filter_image_ids = explode(',', $pb_image_ids);
            } else {
                $filter_image_ids = imaginem_codepack_get_custom_attachments($pageid);
            }
            
            $count_lightboxes = 0;
            
            if ($filter_image_ids) {
                foreach ($filter_image_ids as $attachment_id) {
                    
                    //echo $type, $portfolio_type;
                    $custom                 = get_post_custom(get_the_ID());
                    $portfolio_cats         = get_the_terms(get_the_ID(), 'types');
                    $lightboxvideo          = "";
                    $thumbnail              = "";
                    $customlink_URL         = "";
                    $portfolio_thumb_header = "Image";
                    
                    $imagearray = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                    $imageURI   = $imagearray[0];
                    
                    $thumbnail_imagearray = wp_get_attachment_image_src($attachment_id, $portfolioImage_type, false);
                    $thumbnail_imageURI   = $thumbnail_imagearray[0];
                    
                    if (isSet($thumbnail_imageURI)) {
                        
                        $imageTitle = '';
                        $imageDesc  = '';
                        $imageID    = get_post($attachment_id);
                        if (isSet($imageID->post_title)) {
                            $imageTitle = $imageID->post_title;
                        }
                        if (isSet($imageID->post_content)) {
                            $imageDesc = $imageID->post_content;
                        }
                        
                        if ($portfolio_count == $columns)
                            $portfolio_count = 0;
                        
                        $protected  = "";
                        $icon_class = "column-gridblock-icon";
                        $portfolio_count++;
                        $portfoliogrid .= '<div class="gridblock-grid-element">';
                        $portfoliogrid .= imaginem_codepack_activate_lightbox(
                            $lightbox_type = "magnific",
                            $ID = get_the_ID(),
                            $link = $imageURI,
                            $mediatype = "image",
                            $imagetitle = $imageTitle,
                            $class = "column-gridblock-lightbox lightbox-image",
                            $navigation = "magnific-lightboxcarousel",
                            $data_name = "default",
                            $external_thumbnail_id = $attachment_id,
                            $imageDataID=$attachment_id
                        );
                        $portfoliogrid .= '<div class="gridblock-background-hover">';
                        $portfoliogrid .= '<div class="gridblock-links-wrap">';
                        
                        $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                        
                        if ($icon_class)
                            $portfoliogrid .= '<span class="column-gridblock-icon"><span class="hover-icon-effect">' . $icon_class . '</span></span>';
                        
                        $portfoliogrid .= '</div>';
                        if ($boxtitle == "true") {
                            $portfoliogrid .= '<div class="boxtitle-hover">';
                            $portfoliogrid .= $imageTitle;
                            $portfoliogrid .= '</div>';
                        }
                        $portfoliogrid .= '</div>';
                        
                        $portfoliogrid .= imaginem_codepack_display_post_image(get_the_ID(), $have_image_url = $thumbnail_imageURI, $link = false, $type = $portfolioImage_type, $imagetitle = $imageTitle, $class = "displayed-image");
                        
                        $portfoliogrid .= '</a>';
                        $count_lightboxes++;
                        
                        $portfoliogrid .= '</div>';
                        
                    }
                    
                }
            }
            $portfoliogrid .= '</div>';
            $portfoliogrid .= '</div>';
            if ($count_lightboxes > 0) {
                $portfoliogrid .= '
		<script>
		/* <![CDATA[ */
		(function($){
		$(window).load(function(){
			$("#owl-' . $uniqureID . '").owlCarousel({
				itemsCustom : [
					[0, 1],
					[500, 2],
					[700, 3],
					[1024, ' . $columns . ']
				],
				items: ' . $columns . ',
				nav : true,
				navText : ["",""],
				loop: true
			});
		})
		})(jQuery);
		/* ]]> */
		</script>
		';
            }
            
        }
        
        wp_reset_query();
        return $portfoliogrid;
    }
}
add_shortcode("lightboxcarousel", "mLightboxCarousel");

//Recent Works Carousel
if (!function_exists('mWorksCarousel')) {
    function mWorksCarousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "pageid" => '',
            "format" => '',
            "carousel_type" => 'owl',
            "category_display" => "true",
            "columns" => '4',
            "limit" => '-1',
            "title" => 'true',
            "desc" => 'true',
            "lazyload" => 'false',
            "boxtitle" => 'true',
            "worktype_slug" => '',
            "pagination" => 'true'
        ), $atts));
        
        $uniqureID           = get_the_id() . "-" . uniqid();
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        
        if ($worktype_slug == "-1") {
            $worktype_slug = '';
        }
        $portfolio_count = 0;
        $flag_new_row    = true;
        $portfoliogrid   = '';
        
        if ($carousel_type == "owl") {
            
            $portfoliogrid .= '<div class="gridblock-owlcarousel-wrap clearfix">';
            $portfoliogrid .= '<div id="owl-' . $uniqureID . '" data-id="owl-' . $uniqureID . '" data-lazyload="'.$lazyload.'" data-columns="'.$columns.'" data-pagination="'.$pagination.'" class="owl-carousel owl-works-detect" >';
            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
            query_posts(array(
                'post_type' => 'mtheme_portfolio',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'types' => $worktype_slug,
                'paged' => $paged,
                'posts_per_page' => $limit
            ));
            
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    
                    //echo $type, $portfolio_type;
                    $custom                 = get_post_custom(get_the_ID());
                    $portfolio_cats         = get_the_terms(get_the_ID(), 'types');
                    $lightboxvideo          = "";
                    $portfolio_link_type    = "DirectURL";
                    $thumbnail              = "";
                    $customlink_URL         = "";
                    $portfolio_thumb_header = "Image";

                    $featured_image_id = get_post_thumbnail_id( get_the_id() );
                    $featured_image_data = get_post($featured_image_id);
                    
                    $the_only_link      = false;
                    $the_protected_link = false;
                    
                    if (isset($custom['pagemeta_thumbnail_linktype'][0])) {
                        $portfolio_link_type = $custom['pagemeta_thumbnail_linktype'][0];
                    }
                    if (isset($custom['pagemeta_lightbox_video'][0])) {
                        $lightboxvideo = $custom['pagemeta_lightbox_video'][0];
                    }
                    if (isset($custom['pagemeta_customthumbnail'][0])) {
                        $thumbnail = $custom['pagemeta_customthumbnail'][0];
                    }
                    if (isset($custom['pagemeta_thumbnail_desc'][0])) {
                        $description = $custom['pagemeta_thumbnail_desc'][0];
                    }
                    if (isset($custom['pagemeta_customlink'][0])) {
                        $customlink_URL = $custom['pagemeta_customlink'][0];
                    }
                    if (isset($custom['pagemeta_portfoliotype'][0])) {
                        $portfolio_thumb_header = $custom['pagemeta_portfoliotype'][0];
                    }
                    
                    if ($portfolio_count == $columns)
                        $portfolio_count = 0;
                    
                    $protected  = "";
                    $icon_class = "column-gridblock-icon";

                    $portfolio_count++;
                    $portfoliogrid .= '<div class="gridblock-grid-element">';
                    
                    $portfoliogrid .= '<div class="gridblock-background-hover">';

                    $link_open = false;
                    
                    if (post_password_required()) {
                        $portfolio_link_type = "DirectURL";
                    }

                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    }

                        if ($portfolio_link_type == "Lightbox_DirectURL") {
                            $portfoliogrid .= '<a class="column-gridblock-icon" href="' . get_permalink() . '">';
                            $portfoliogrid .= '<span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i></span>';
                            $portfoliogrid .= '</a>';
                        }
                        
                        switch ($portfolio_link_type) {
                            case 'DirectURL':
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                                $link_open = true;
                                break;
                            
                            case 'Customlink':
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . $customlink_URL . '">';
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('link') . '"></i>';
                                $link_open = true;
                                break;
                            
                            case 'Lightbox_DirectURL':
                                if ($lightboxvideo <> "") {
                                    $get_lightbox_link = imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default",
                                        $ID = get_the_id(),
                                        $predefined = $lightboxvideo,
                                        $mediatype = "video",
                                        $imagetitle = get_the_title(),
                                        $class = "column-gridblock-icon column-gridblock-lightbox lightbox-video",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                    );
                                    if ($get_lightbox_link) {
                                        $portfoliogrid .= $get_lightbox_link;
                                        $link_open = true;
                                    }
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                                } else {
                                    $get_lightbox_link = imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default", $ID = get_the_id(),
                                        $predefined = imaginem_codepack_featured_image_link(get_the_ID()),
                                        $mediatype = "image",
                                        $imagetitle = imaginem_codepack_image_title(get_the_ID()),
                                        $class = "column-gridblock-icon column-gridblock-lightbox lightbox-image",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                    );
                                    if ($get_lightbox_link) {
                                        $portfoliogrid .= $get_lightbox_link;
                                        $link_open = true;
                                    }
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                                }
                                break;
                            case 'Lightbox':
                                $the_only_link = true;
                                if ($lightboxvideo <> "") {
                                    $get_lightbox_link = imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default", $ID = get_the_id(),
                                        $predefined = $lightboxvideo,
                                        $mediatype = "video",
                                        $imagetitle = get_the_title(),
                                        $class = "gridblock-sole-link column-gridblock-lightbox lightbox-video",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                    );
                                    if ($get_lightbox_link) {
                                        $portfoliogrid .= $get_lightbox_link;
                                        $link_open = true;
                                    }
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                                } else {
                                    $get_lightbox_link = imaginem_codepack_activate_lightbox(
                                        $lightbox_type = "default",
                                        $ID = get_the_id(),
                                        $predefined = imaginem_codepack_featured_image_link(get_the_ID()),
                                        $mediatype = "image",
                                        $imagetitle = imaginem_codepack_image_title(get_the_ID()),
                                        $class = "gridblock-sole-link column-gridblock-lightbox lightbox-image",
                                        $set = "portfolio-grid",
                                        $data_name = "default",
                                        $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                        $imageDataID=$featured_image_id
                                    );
                                    if ($get_lightbox_link) {
                                        $portfoliogrid .= $get_lightbox_link;
                                        $link_open = true;
                                    }
                                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                                }
                                break;
                            default:
                                $the_only_link = true;
                                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                                $link_open = true;
                                break;
                        }
                        
                        if ($portfolio_link_type != "Lightbox_DirectURL") {
                            $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                        }

                        if (post_password_required()) {
                            $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('locked') . '"></i>';
                        }
                        //$portfoliogrid .= '<span class="gridblock-image-hover">';
                        if (isSet($icon_class)) {
                            if ($the_only_link) {
                                $portfoliogrid .= '<span class="column-gridblock-icon">';
                            }
                            $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                            if ($the_only_link) {
                                $portfoliogrid .= '</span>';
                            }
                        }
                        if ($portfolio_link_type != "Lightbox_DirectURL") {
                            $portfoliogrid .= '</div>';
                        }
                        if ($link_open) {
                            $portfoliogrid .= '</a>';
                        }
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '</div>';
                    }
                    //$portfoliogrid .= '</span>';
                    // If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
                    // Custom Thumbnail
                    if ($boxtitle == "true") {
                        
                        $current_terms    = wp_get_object_terms(get_the_ID(), 'types');
                        $current_worktype = '';
                        $seperator        = ',';
                        foreach ($current_terms as $the_term) {
                            if ($the_term === end($current_terms)) {
                                $seperator = '';
                            }
                            $current_worktype .= $the_term->name . $seperator;
                        }
                        
                        $portfoliogrid .= '<span class="boxtitle-hover">';
                        $portfoliogrid .= '<a href="' . get_permalink() . '">';
                        $portfoliogrid .= get_the_title();
                        $portfoliogrid .= '</a>';
                        if ($category_display=="true") {
                            $portfoliogrid .= '<span class="boxtitle-worktype">' . $current_worktype . '</span>';
                        }
                        $portfoliogrid .= '</span>';
                    }
                    $portfoliogrid .= '</div>';
                    
                    if ($thumbnail <> "") {
                        $portfoliogrid .= '<img src="' . $thumbnail . '" class="displayed-image" alt="thumbnail" />';
                    } else {
                        // Slideshow then generate slideshow shortcode
                        $portfoliogrid .= imaginem_codepack_display_post_image(get_the_ID(), $have_image_url = "", $link = false, $imagetype = $portfolioImage_type, $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = "displayed-image");
                        
                    }
                
                    
                    $portfoliogrid .= '</div>';
                endwhile;
            endif;
            $portfoliogrid .= '</div>';
            $portfoliogrid .= '</div>';
            
            if ($pagination <> "true") {
                $pagination = "false";
            }
            
        }
        
        wp_reset_query();
        return $portfoliogrid;
    }
}
add_shortcode("workscarousel", "mWorksCarousel");
// Since version 2.5
if (!function_exists('mtheme_shortcode_worktype_albums')) {
    function mtheme_shortcode_worktype_albums($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "worktype_slugs" => '',
            "format" => '',
            "columns" => 4,
            "item_text" => 'image',
            "items_text" => 'images',
            "item_count" => true,
            "title" => true,
            "description" => true,
            "worktype_icon" => 'ion-ios-albums-outline'
        ), $atts));

        $animation_class = ' grid-animate-display-all';
        
        if ($worktype_icon == "") {
            $worktype_icon = 'ion-ios-albums-outline';
        }
        
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $column_type         = "one";
            $portfolioImage_type = "kreativa-gridblock-full";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
        //$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
        
        $add_space_class = '';
        if ($title == 'false' && $description == 'false') {
            $add_space_class = 'gridblock-cell-bottom-space';
        }
        
        
        $portfoliogrid = '<div class="gridblock-columns-wrap clearfix">';
        $portfoliogrid .= '<div id="gridblock-container" class="portfolio-gutter-spaced gridblock-' . $column_type . ' clearfix">';
        
        //$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
        if ($worktype_slugs != '')
            $all_works = explode(",", $worktype_slugs);
        $categories = get_categories('orderby=slug&taxonomy=types&title_li=');
        
        foreach ($categories as $category) {
            $taxonomy = "types"; // can be category, post_tag, or custom taxonomy name
            
            // Use any one of the three methods below
            
            // Using Term ID
            //$term_id = $category->term_id;
            //$term = get_term_by('id', $term_id, $taxonomy);
            
            // Using Term Name
            //$term_name = 'A Category';
            //$term = get_term_by('name', $term_name, $taxonomy);
            
            // Using Term Slug
            $term_slug = $category->slug;
            $term      = get_term_by('slug', $term_slug, $taxonomy);
            
            // Enter only if Works is not set - means all included OR if work types are defined in shortcode
            if (!isSet($all_works) || in_array($term_slug, $all_works)) {
                // Fetch the count
                //echo $term->count;
                
                
                $hreflink                 = get_term_link($category->slug, 'types');
                $mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $category->term_id);
                $work_type_image          = wp_get_attachment_image_src($mtheme_worktype_image_id, $portfolioImage_type, false);
                
                $portfoliogrid .= '<div class="gridblock-element ' . $animation_class . ' ' . $add_space_class . '">';
                $portfoliogrid .= '<div class="gridblock-grid-element gridblock-element-inner">';
                $portfoliogrid .= '<div class="gridblock-background-hover">';
                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . $hreflink . '">
												<div class="gridblock-links-wrap">
													<span class="column-gridblock-icon">
														<span class="hover-icon-effect">
															<i class="' . $worktype_icon . '"></i>
														</span>
													</span>';
                
                if ($item_count == 'true') {
                    
                    //Count the items and reset
                    $countquery = array(
                        'post_type' => 'mtheme_portfolio',
                        'types' => $category->slug,
                        'posts_per_page' => -1
                    );
                    query_posts($countquery);
                    $item_counter = 0;
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            $item_counter++;
                        endwhile;
                    endif;
                    
                    wp_reset_query();
                    
                    //Check number of items
                    if ($item_counter == 1) {
                        $count_suffix = $item_text;
                    } else {
                        $count_suffix = $items_text;
                    }
                    $portfoliogrid .= '<span class="album-item-count"><span>' . $item_counter . ' ' . $count_suffix . '</span></span>';
                }
                $portfoliogrid .= '</div></a>
											</div>';
                // //$portfoliogrid .= $preload_tag;
                // $portfoliogrid .= '<span class="gridblock-image-link album-image-wrap">';
                
                // To display count
                //Display image
                $portfoliogrid .= '<img class="preload-image displayed-image" src="' . $work_type_image[0] . '" alt="' . get_the_title() . '">';
                //$portfoliogrid .= '</span>';
                $portfoliogrid .= '</div>';
                if ($title == "true" || $description == "true") {
                    $portfoliogrid .= '<div class="work-details">';
                    if ($title == 'true') {
                        $portfoliogrid .= '<h4>';
                        $portfoliogrid .= '<a href="' . $hreflink . '">';
                        $portfoliogrid .= $category->name;
                        $portfoliogrid .= '</a>';
                        $portfoliogrid .= '</h4>';
                    }
                    if ($description == 'true') {
                        $portfoliogrid .= '<p class="entry-content work-description">' . $category->description . '</p>';
                    }
                    $portfoliogrid .= '</div>';
                }
                
                $portfoliogrid .= '</div>';
            }
        }
        $portfoliogrid .= '</div>';
        $portfoliogrid .= '</div>';
        
        return $portfoliogrid;
    }
}
add_shortcode("worktype_albums", "mtheme_shortcode_worktype_albums");
/**
 * Portfolio Grid
 */
if (!function_exists('mmtheme_GalleryGrids')) {
    function mmtheme_GalleryGrids($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "pageid" => '',
            "format" => '',
            "columns" => '4',
            "limit" => '-1',
            "animated" => 'true',
            "grid_post_type" => '',
            "grid_taxonomy" => '',
            "displaycategory" => 'false',
            "gutter" => 'spaced',
            "boxtitle" => 'true',
            "title" => 'true',
            "desc" => 'true',
            "worktype_slugs" => '',
            "pagination" => 'false',
            "type" => 'filter'
        ), $atts));

        if ($animated == "true") {
            $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
        }
        
        
        $portfoliogrid       = '';
        // Set a default
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $column_type         = "one";
            $portfolioImage_type = "kreativa-gridblock-full";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        $gridblock_is_masonary = "";
        if ($format == "masonary") {
            
            $gridblock_is_masonary = "gridblock-masonary ";
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
        //$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
        $thumbnail_gutter_class = 'portfolio-gutter-' . $gutter . ' ';
        if ($gutter == "nospace") {
            $thumbnail_gutter_class .= 'thumnails-gutter-active ';
        }
        $flag_new_row = true;
        
        if ($format == "square") {
            $portfolioImage_type = "kreativa-gridblock-square-big";
        }
        
        $xtra_class = '';
        if ($desc == 'false') {
            $xtra_class = ' gridblock-desc-off';
        }
        $portfoliogrid .= '<div class="gridblock-columns-wrap clearfix">';
        $portfoliogrid .= '<div id="gridblock-container" class="' . $thumbnail_gutter_class . $gridblock_is_masonary . 'gridblock-' . $column_type . $xtra_class . ' post-grid-' . $grid_post_type . ' clearfix" data-columns="' . $columns . '">';
        // if ($format=="masonary") {
        // 	$portfoliogrid .= '<div class="gridblock-masonary-inner">';
        // }
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        
        $count           = 0;
        $terms           = array();
        $work_slug_array = array();
        //echo $worktype_slugs;
        if ($worktype_slugs != "" && $grid_taxonomy != '') {
            $type_explode = explode(",", $worktype_slugs);
            foreach ($type_explode as $work_slug) {
                $terms[] = $work_slug;
            }
            query_posts(array(
                'post_type' => $grid_post_type,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $limit,
                'tax_query' => array(
                    array(
                        'taxonomy' => $grid_taxonomy,
                        'field' => 'slug',
                        'terms' => $terms,
                        'operator' => 'IN'
                    )
                )
            ));
        } else {
            query_posts(array(
                'post_type' => $grid_post_type,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'paged' => $paged,
                'posts_per_page' => $limit
            ));
        }
        
        $idCount               = 1;
        $portfolio_count       = 0;
        $portfolio_total_count = 0;
        
        if (have_posts()):
            while (have_posts()):
                the_post();
                //echo $type, $portfolio_type;
                $custom                 = get_post_custom(get_the_ID());
                $portfolio_cats         = get_the_terms(get_the_ID(), 'fullscreengallery');
                $lightboxvideo          = "";
                $thumbnail              = "";
                $customlink_URL         = "";
                $description            = "";
                $portfolio_thumb_header = "Image";
                
                if (isset($custom['pagemeta_thumbnail_linktype'][0])) {
                    $portfolio_link_type = $custom['pagemeta_thumbnail_linktype'][0];
                }
                if (isset($custom['pagemeta_lightbox_video'][0])) {
                    $lightboxvideo = $custom['pagemeta_lightbox_video'][0];
                }
                if (isset($custom['pagemeta_customthumbnail'][0])) {
                    $thumbnail = $custom['pagemeta_customthumbnail'][0];
                }
                if (isset($custom['pagemeta_thumbnail_desc'][0])) {
                    $description = $custom['pagemeta_thumbnail_desc'][0];
                }
                if (isset($custom['pagemeta_customlink'][0])) {
                    $customlink_URL = $custom['pagemeta_customlink'][0];
                }
                if (isset($custom['pagemeta_portfoliotype'][0])) {
                    $portfolio_thumb_header = $custom['pagemeta_portfoliotype'][0];
                }
                
                if ($portfolio_count == $columns)
                    $portfolio_count = 0;
                
                $add_space_class = '';
                $xtra_class      = '';
                if ($gutter != 'nospace') {
                    if ($title == 'false' && $desc == 'false') {
                        $add_space_class = 'gridblock-cell-bottom-space';
                    }
                }
                $title_desc_class = '';
                if ($grid_post_type == "mtheme_clients") {
                    if ($title == "false") {
                        $title_desc_class = " no-title-no-desc";
                        $add_space_class  = '';
                    }
                }
                $boxtitle_class = '';
                if ($boxtitle == "true") {
                    $boxtitle_class = " boxtitle-active";
                }
                
                $protected  = "";
                $icon_class = "column-gridblock-icon";
                $portfolio_count++;
                $portfolio_total_count++;
                
                $gridblock_ajax_class = '';
                if ($type == 'ajax') {
                    $gridblock_ajax_class = "gridblock-ajax ";
                }
                
                // Generate main DIV tag with portfolio information with filterable tags
                $portfoliogrid .= '<div class="gridblock-element '.$animation_class.' gridblock-element-id-' . get_the_ID() . ' gridblock-element-order-' . $portfolio_total_count . ' ' . $add_space_class . $boxtitle_class . $title_desc_class . ' gridblock-filterable ';
                if (is_array($portfolio_cats)) {
                    foreach ($portfolio_cats as $taxonomy) {
                        $portfoliogrid .= 'filter-' . $taxonomy->slug . ' ';
                    }
                }
                $idCount++;
                $portfoliogrid .= '" data-portfolio="portfolio-' . get_the_ID() . '" data-id="id-' . $idCount . '">';
                $portfoliogrid .= '<div class="' . $gridblock_ajax_class . 'gridblock-grid-element gridblock-element-inner" data-portfolioid="' . get_the_id() . '">';
                
                $portfoliogrid .= '<div class="gridblock-background-hover">';
                $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                $portfoliogrid .= '<div class="gridblock-links-wrap">';
                
                
                if (post_password_required()) {
                    $portfoliogrid .= '<span class="column-gridblock-icon">';
                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('locked') . '"></i>';
                    //$portfoliogrid .= '<span class="gridblock-image-hover">';
                    if (isSet($icon_class)) {
                        $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                    }
                    $portfoliogrid .= '</span>';
                } else {
                    
                    $portfoliogrid .= '<span class="column-gridblock-icon">';
                    $icon_class = '<i class="ion-ios-albums-outline"></i>';
                    //$portfoliogrid .= '<span class="gridblock-image-hover">';
                    if (isSet($icon_class)) {
                        $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                    }
                    $portfoliogrid .= '</span>';
                }
                
                $portfoliogrid .= '</div>';
                $portfoliogrid .= '</a>';
                
                if ($boxtitle == "true") {
                    
                    $current_terms    = wp_get_object_terms(get_the_ID(), 'types');
                    $current_worktype = '';
                    $seperator        = ',';
                    foreach ($current_terms as $the_term) {
                        if ($the_term === end($current_terms)) {
                            $seperator = '';
                        }
                        $current_worktype .= $the_term->name . $seperator;
                    }
                    
                    $portfoliogrid .= '<span class="boxtitle-hover">';
                    $portfoliogrid .= '<a href="' . get_permalink() . '">';
                    $portfoliogrid .= get_the_title();
                    $portfoliogrid .= '</a>';
                    $portfoliogrid .= '<span class="boxtitle-worktype">' . $current_worktype . '</span>';
                    $portfoliogrid .= '</span>';
                }
                $portfoliogrid .= '</div>';
                
                if ($thumbnail <> "") {
                    $portfoliogrid .= '<img src="' . $thumbnail . '" class="displayed-image" alt="thumbnail" />';
                } else {
                    // Slideshow then generate slideshow shortcode
                    $portfoliogrid .= imaginem_codepack_display_post_image(get_the_ID(), $have_image_url = "", $link = false, $imagetype = $portfolioImage_type, $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = "displayed-image");
                    
                }
                $portfoliogrid .= '</div>';
                if ($title == 'true' || $desc == 'true') {
                    $portfoliogrid .= '<div class="work-details">';
                    $hreflink = get_permalink();
                    if ($title == 'true') {
                        if ($type != "ajax") {
                            $portfoliogrid .= '<h4><a href="' . $hreflink . '">' . get_the_title() . '</a></h4>';
                        } else {
                            $portfoliogrid .= '<h4>';
                            $portfoliogrid .= '' . get_the_title() . '';
                            $portfoliogrid .= '</h4>';
                        }
                    }
                    if ($desc == 'true') {
                        $portfoliogrid .= '<p class="entry-content work-description">' . $description . '</p>';
                    }
                    $portfoliogrid .= '</div>';
                }
                
                
                $portfoliogrid .= '</div>';
            //if ($portfolio_count==$columns)  $portfoliogrid .='</div>';
            endwhile;
        endif;
        // if ($format=="masonary") {
        // 	$portfoliogrid .= '</div>';
        // }
        $portfoliogrid .= '</div>';
        $portfoliogrid .= '</div>';
        
        if ($pagination == 'true') {
            $portfoliogrid .= '<div class="clearfix">';
            $portfoliogrid .= imaginem_codepack_pagination();
            $portfoliogrid .= '</div>';
        }
        
        wp_reset_query();
        return $portfoliogrid;
    }
}
add_shortcode("gallerygrid", "mmtheme_GalleryGrids");
/**
 * Portfolio Grid
 */
if (!function_exists('mGridCreate')) {
    function mGridCreate($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "pageid" => '',
            "grid_post_type" => '',
            "category_display" => "true",
            "grid_tax_type" => '',
            "animated" => 'true',
            "event_status" => '',
            "format" => '',
            "columns" => '4',
            "limit" => '-1',
            "gutter" => 'spaced',
            "boxtitle" => 'true',
            "title" => 'true',
            "desc" => 'true',
            "worktype_slugs" => '',
            "pagination" => 'false',
            "type" => 'filter'
        ), $atts));
        
        $portfoliogrid = '';

        if ($animated == "true" ) {
            $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
        }
        
        if ($type == "filter" || $type == "ajax") {
            
            $countquery = array(
                'post_type' => $grid_post_type,
                'types' => $worktype_slugs,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'posts_per_page' => -1
            );
            query_posts($countquery);
            if (have_posts()):
                while (have_posts()):
                    the_post();
                endwhile;
            endif;
            
            if ($type == "ajax") {
                $portfoliogrid .= '	<div class="ajax-gridblock-block-wrap clearfix">';
                $portfoliogrid .= '	<div class="ajax-gallery-navigation clearfix">';
                $portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-next" href="#"><i class="feather-icon-arrow-right"></i></a>';
                $portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-hide" href="#"><i class="feather-icon-align-justify"></i></a>';
                $portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-prev" href="#"><i class="feather-icon-arrow-left"></i></a>';
                $portfoliogrid .= '		<span class="ajax-loading">Loading</span>';
                $portfoliogrid .= '	</div>';
                $portfoliogrid .= '	<div class="ajax-gridblock-window">';
                $portfoliogrid .= '		<div id="ajax-gridblock-wrap"></div>';
                $portfoliogrid .= '	</div>';
                $portfoliogrid .= '	</div>';
            }
            $portfoliogrid .= '<div class="gridblock-filter-select-wrap">';
            $portfoliogrid .= '<ul id="gridblock-filters">';
            
            $portfoliogrid .= '<li>';
            $portfoliogrid .= '<a data-filter="*" data-title="' . imaginem_codepack_get_option_data('portfolio_allitems') . '" href="#">';
            $portfoliogrid .= imaginem_codepack_get_option_data('portfolio_allitems');
            $portfoliogrid .= '</a>';
            $portfoliogrid .= '</li>';
            
            //$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
            if ($worktype_slugs != '')
                $all_works = explode(",", $worktype_slugs);
            $categories = get_categories('orderby=slug&taxonomy=' . $grid_tax_type . '&title_li=');
            foreach ($categories as $category) {
                
                $taxonomy = $grid_tax_type;
                
                // Using Term Slug
                $term_slug = $category->slug;
                $term      = get_term_by('slug', $term_slug, $taxonomy);
                
                // Enter only if Works is not set - means all included OR if work types are defined in shortcode
                if (!isSet($all_works) || in_array($term_slug, $all_works)) {
                    // Fetch the count
                    //echo $term->count;
                    $portfoliogrid .= '<li>';
                    $portfoliogrid .= '<a data-filter=".filter-' . $category->slug . '" data-title="' . $category->name . '" href="#">';
                    $portfoliogrid .= $category->name;
                    $portfoliogrid .= '</a>';
                    $portfoliogrid .= '</li>';
                }
            }
            $portfoliogrid .= '</ul>';
            $portfoliogrid .= '</div>';
            //End of If Filter
        }
        //Reset query after Filters
        wp_reset_query();
        
        // Set a default
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        
        if ($columns == 4) {
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $column_type         = "one";
            $portfolioImage_type = "kreativa-gridblock-full";
        }
        
        if ($format == "portrait") {
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-large-portrait";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        $gridblock_is_masonary = "";
        if ($format == "masonary") {
            
            $gridblock_is_masonary = "gridblock-masonary ";
            if ($columns == 4) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 3) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 2) {
                $portfolioImage_type = "kreativa-gridblock-full-medium";
            }
            if ($columns == 1) {
                $portfolioImage_type = "kreativa-gridblock-full";
            }
        }
        
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
        //$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
        $thumbnail_gutter_class = 'portfolio-gutter-' . $gutter . ' ';
        if ($gutter == "nospace") {
            $thumbnail_gutter_class .= 'thumnails-gutter-active ';
        }
        $flag_new_row = true;
        
        
        $portfoliogrid .= '<div class="gridblock-columns-wrap clearfix">';
        $portfoliogrid .= '<div id="gridblock-container" class="' . $thumbnail_gutter_class . $gridblock_is_masonary . 'gridblock-' . $column_type . ' clearfix" data-columns="' . $columns . '">';
        // if ($format=="masonary") {
        // 	$portfoliogrid .= '<div class="gridblock-masonary-inner">';
        // }
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        
        $count           = 0;
        $terms           = array();
        $work_slug_array = array();
        $filter_events = false;
        //echo $worktype_slugs;
        if ($worktype_slugs != "") {
            $type_explode = explode(",", $worktype_slugs);
            foreach ($type_explode as $work_slug) {
                $terms[] = $work_slug;
            }

            if ($grid_post_type == "mtheme_events") {

                if ( $event_status == "postponed" ) {
                    $filter_events = true;
                    $events_to_look = "postponed";
                }
                if ( $event_status == "cancelled" ) {
                    $filter_events = true;
                    $events_to_look = "cancelled";
                }
                if ( $event_status == "pastevent" ) {
                    $filter_events = true;
                    $events_to_look = "pastevent";
                }
                if ( $event_status == "allevents" ) {
                    $filter_events = false;
                }

                $events_meta_query = 
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => 'inactive',
                            'compare' => 'NOT IN'
                        )
                    );

                if ($filter_events) {
                    $events_meta_query = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => 'inactive',
                            'compare' => 'NOT IN'
                        ),
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => $events_to_look,
                            'compare' => 'EXISTS'
                        )                        
                    );                    
                }
                query_posts(array(
                    'post_type' => $grid_post_type,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'paged' => $paged,
                    'posts_per_page' => $limit,
                    'meta_query' => $events_meta_query,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $grid_tax_type,
                            'field' => 'slug',
                            'terms' => $terms,
                            'operator' => 'IN'
                        )
                    )
                ));
            } else {
                query_posts(array(
                    'post_type' => $grid_post_type,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'paged' => $paged,
                    'posts_per_page' => $limit,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $grid_tax_type,
                            'field' => 'slug',
                            'terms' => $terms,
                            'operator' => 'IN'
                        )
                    )
                ));
            }
        } else {
            
            if ($grid_post_type == "mtheme_events") {

                if ( $event_status == "postponed" ) {
                    $filter_events = true;
                    $events_to_look = "postponed";
                }
                if ( $event_status == "cancelled" ) {
                    $filter_events = true;
                    $events_to_look = "cancelled";
                }
                if ( $event_status == "pastevent" ) {
                    $filter_events = true;
                    $events_to_look = "pastevent";
                }
                if ( $event_status == "allevents" ) {
                    $filter_events = false;
                }

                $events_meta_query = 
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => 'inactive',
                            'compare' => 'NOT IN'
                        )
                    );

                if ($filter_events) {
                    $events_meta_query = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => 'inactive',
                            'compare' => 'NOT IN'
                        ),
                        array(
                            'key' => 'pagemeta_event_notice',
                            'value' => $events_to_look,
                            'compare' => 'LIKE'
                        )                        
                    );                    
                }

                query_posts(array(
                    'post_type' => $grid_post_type,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'paged' => $paged,
                    'posts_per_page' => $limit,
                    'meta_query' => $events_meta_query
                ));
            } else {
                query_posts(array(
                    'post_type' => $grid_post_type,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'paged' => $paged,
                    'posts_per_page' => $limit
                ));
            }
        }
        
        $idCount               = 1;
        $portfolio_count       = 0;
        $portfolio_total_count = 0;
        $portfoliofilters      = array();
        
        if (have_posts()):
            while (have_posts()):
                the_post();
                //echo $type, $portfolio_type;
                $custom                 = get_post_custom(get_the_ID());
                $portfolio_cats         = get_the_terms(get_the_ID(), 'types');
                $lightboxvideo          = "";
                $thumbnail              = "";
                $customlink_URL         = "";
                $description            = "";
                $portfolio_link_type    = "";
                $portfolio_thumb_header = "Image";
                $the_only_link          = false;
                $the_protected_link     = false;
                
                if (isset($custom['pagemeta_thumbnail_linktype'][0])) {
                    $portfolio_link_type = $custom['pagemeta_thumbnail_linktype'][0];
                }
                if (isset($custom['pagemeta_lightbox_video'][0])) {
                    $lightboxvideo = $custom['pagemeta_lightbox_video'][0];
                }
                if (isset($custom['pagemeta_customthumbnail'][0])) {
                    $thumbnail = $custom['pagemeta_customthumbnail'][0];
                }
                if (isset($custom['pagemeta_thumbnail_desc'][0])) {
                    $description = $custom['pagemeta_thumbnail_desc'][0];
                }
                if (isset($custom['pagemeta_customlink'][0])) {
                    $customlink_URL = $custom['pagemeta_customlink'][0];
                }
                if (isset($custom['pagemeta_portfoliotype'][0])) {
                    $portfolio_thumb_header = $custom['pagemeta_portfoliotype'][0];
                }
                
                if ($portfolio_count == $columns)
                    $portfolio_count = 0;
                
                $add_space_class = '';
                if ($gutter != 'nospace') {
                    if ($title == 'false' && $desc == 'false') {
                        $add_space_class = 'gridblock-cell-bottom-space';
                    }
                }
                
                $protected  = "";
                $icon_class = "column-gridblock-icon";
                $portfolio_count++;
                $portfolio_total_count++;
                
                $gridblock_ajax_class = '';
                if ($type == 'ajax') {
                    $gridblock_ajax_class = "gridblock-ajax ";
                }
                
                // Generate main DIV tag with portfolio information with filterable tags
                $portfoliogrid .= '<div class="gridblock-element isotope-displayed '.$animation_class.' gridblock-element-id-' . get_the_ID() . ' gridblock-element-order-' . $portfolio_total_count . ' ' . $add_space_class . ' gridblock-filterable ';
                if (is_array($portfolio_cats)) {
                    foreach ($portfolio_cats as $taxonomy) {
                        $portfoliogrid .= 'filter-' . $taxonomy->slug . ' ';
                        if ($pagination == 'true') {
                            if (in_array($taxonomy->slug, $portfoliofilters)) {
                            } else {
                                $portfoliofilters[] = $taxonomy->slug;
                            }
                        }
                    }
                }
                $idCount++;
                $portfoliogrid .= '" data-portfolio="portfolio-' . get_the_ID() . '" data-id="id-' . $idCount . '">';
                $portfoliogrid .= '<div class="' . $gridblock_ajax_class . 'gridblock-grid-element gridblock-element-inner" data-portfolioid="' . get_the_id() . '">';
                
                $portfoliogrid .= '<div class="gridblock-background-hover">';
                
                if (post_password_required()) {
                    $the_only_link       = true;
                    $the_protected_link  = true;
                    $portfolio_link_type = "Protected";
                    $protected           = " gridblock-protected";
                    $iconclass           = "";
                }
                
                
                //if Password Required
                
                //Make sure it's not a slideshow
                if ($type != "ajax") {
                    //Switch check for Linked Type
                    //Switch check for Linked Type
                    //
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    }
                    
                    if (post_password_required()) {
                        $portfolio_link_type = 'DirectURL';
                    }
                    
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '<a class="column-gridblock-icon" href="' . get_permalink() . '">';
                        $portfoliogrid .= '<span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i></span>';
                        $portfoliogrid .= '</a>';
                    }
                    
                    
                    switch ($portfolio_link_type) {
                        case 'DirectURL':
                            $the_only_link = true;
                            $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                            $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                            break;
                        
                        case 'Customlink':
                            $the_only_link = true;
                            $portfoliogrid .= '<a class="gridblock-sole-link" href="' . $customlink_URL . '">';
                            $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('link') . '"></i>';
                            break;
                        
                        case 'Lightbox_DirectURL':
                            if ($lightboxvideo <> "") {
                                $portfoliogrid .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $lightboxvideo, $mediatype = "video", $imagetitle = get_the_title(), $class = "column-gridblock-icon column-gridblock-lightbox lightbox-video", $set = "portfolio-grid", $data_name = "default");
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                            } else {
                                $portfoliogrid .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = imaginem_codepack_featured_image_link(get_the_ID()), $mediatype = "image", $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = "column-gridblock-icon column-gridblock-lightbox lightbox-image", $set = "portfolio-grid", $data_name = "default");
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                            }
                            break;
                        case 'Lightbox':
                            $the_only_link = true;
                            if ($lightboxvideo <> "") {
                                $portfoliogrid .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $lightboxvideo, $mediatype = "video", $imagetitle = get_the_title(), $class = "gridblock-sole-link column-gridblock-lightbox lightbox-video", $set = "portfolio-grid", $data_name = "default");
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('play') . '"></i>';
                            } else {
                                $portfoliogrid .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = imaginem_codepack_featured_image_link(get_the_ID()), $mediatype = "image", $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = "gridblock-sole-link column-gridblock-lightbox lightbox-image", $set = "portfolio-grid", $data_name = "default");
                                $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i>';
                            }
                            break;
                        default:
                            $the_only_link = true;
                            $portfoliogrid .= '<a class="gridblock-sole-link" href="' . get_permalink() . '">';
                            $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i>';
                            break;
                    }
                    
                    if (post_password_required()) {
                        $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('locked') . '"></i>';
                    }
                    
                    if ($portfolio_link_type != "Lightbox_DirectURL") {
                        $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    }
                    //$portfoliogrid .= '<span class="gridblock-image-hover">';
                    if (isSet($icon_class)) {
                        if ($the_only_link) {
                            $portfoliogrid .= '<span class="column-gridblock-icon">';
                        }
                        $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                        if ($the_only_link) {
                            $portfoliogrid .= '</span>';
                        }
                    }
                    if ($portfolio_link_type != "Lightbox_DirectURL") {
                        $portfoliogrid .= '</div>';
                    }
                    $portfoliogrid .= '</a>';
                    
                    if ($portfolio_link_type == "Lightbox_DirectURL") {
                        $portfoliogrid .= '</div>';
                    }
                    //$portfoliogrid .= '</span>';
                    // If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
                    // Custom Thumbnail
                    // If AJAX
                } else {
                    $portfoliogrid .= '<div class="gridblock-links-wrap box-title-' . $boxtitle . '">';
                    $portfoliogrid .= '<span class="column-gridblock-icon">';
                    $icon_class = '<i class="' . imaginem_codepack_get_portfolio_icon('ajax') . '"></i>';
                    $portfoliogrid .= '<span class="hover-icon-effect">' . $icon_class . '</span>';
                    $portfoliogrid .= '</span>';
                    $portfoliogrid .= '</div>';
                }
                if ($boxtitle == "true") {
                    
                    $current_terms    = wp_get_object_terms(get_the_ID(), 'types');
                    $current_worktype = '';
                    $seperator        = ',';
                    foreach ($current_terms as $the_term) {
                        if ($the_term === end($current_terms)) {
                            $seperator = '';
                        }
                        $current_worktype .= $the_term->name . $seperator;
                    }
                    
                    $portfoliogrid .= '<span class="boxtitle-hover">';
                    $portfoliogrid .= '<a href="' . get_permalink() . '">';
                    $portfoliogrid .= get_the_title();
                    $portfoliogrid .= '</a>';
                    $portfoliogrid .= '<span class="boxtitle-worktype">' . $current_worktype . '</span>';
                    $portfoliogrid .= '</span>';
                }
                $portfoliogrid .= '</div>';
                
                $fade_in_class = "";
                if ($thumbnail <> "") {
                    $portfoliogrid .= '<img src="' . $thumbnail . '" class="' . $fade_in_class . 'displayed-image" alt="thumbnail" />';
                } else {
                    // Slideshow then generate slideshow shortcode
                    $portfoliogrid .= imaginem_codepack_display_post_image(get_the_ID(), $have_image_url = "", $link = false, $imagetype = $portfolioImage_type, $imagetitle = imaginem_codepack_image_title(get_the_ID()), $class = $fade_in_class . "displayed-image");
                    
                }
                $portfoliogrid .= '</div>';
                if ($title == 'true' || $desc == 'true') {
                    $portfoliogrid .= '<div class="work-details">';
                    
                    if ($grid_post_type == "mtheme_events") {
                        $event_start_datetime = '';
                        $event_end_datetime   = '';
                        $event_startdate      = '';
                        $event_enddate        = '';
                        if (isset($custom['pagemeta_event_startdate'][0]))
                            $event_startdate = $custom['pagemeta_event_startdate'][0];
                        if (isset($custom['pagemeta_event_enddate'][0]))
                            $event_enddate = $custom['pagemeta_event_enddate'][0];
                        $event_start_datetime = explode(" ", $event_startdate);
                        $event_end_datetime   = explode(" ", $event_enddate);
                        $start_date           = date_i18n(get_option('date_format'), strtotime($event_start_datetime[0]));
                        $end_date             = date_i18n(get_option('date_format'), strtotime($event_end_datetime[0]));
                        $portfoliogrid .= '<div class="worktype-categories">' . $start_date . ' - ' . $end_date . '</div>';
                    }
                    $hreflink = get_permalink();
                    if ($category_display == 'true') {
                        if ($grid_post_type != "mtheme_events") {
                            $current_terms    = wp_get_object_terms(get_the_ID(), 'types');
                            $current_worktype = '';
                            $seperator        = ' , ';
                            foreach ($current_terms as $the_term) {
                                if ($the_term === end($current_terms)) {
                                    $seperator = '';
                                }
                                $current_worktype .= $the_term->name . $seperator;
                            }
                            $portfoliogrid .= '<div class="worktype-categories">' . $current_worktype . '</div>';
                        }
                    }
                    if ($title == 'true') {
                        if ($type != "ajax") {
                            $portfoliogrid .= '<h4><a href="' . $hreflink . '">' . get_the_title() . '</a></h4>';
                        } else {
                            $portfoliogrid .= '<h4>';
                            $portfoliogrid .= get_the_title();
                            $portfoliogrid .= '</h4>';
                        }
                    }
                    if ($desc == 'true')
                        $portfoliogrid .= '<p class="entry-content work-description">' . $description . '</p>';
                    $portfoliogrid .= '</div>';
                }
                
                
                $portfoliogrid .= '</div>';
            //if ($portfolio_count==$columns)  $portfoliogrid .='</div>';
            endwhile;
        endif;
        // if ($format=="masonary") {
        // 	$portfoliogrid .= '</div>';
        // }
        $portfoliogrid .= '</div>';
        $portfoliogrid .= '</div>';
        
        if ($pagination == 'true') {
            $portfoliogrid .= '<div class="clearfix">';
            $portfoliogrid .= imaginem_codepack_pagination();
            $portfoliogrid .= '</div>';
        }
        
        wp_reset_query();
        
        if ($type == "filter" || $type == "ajax") {
            
            $filter_portfoliogrid = "";
            
            $countquery = array(
                'post_type' => 'mtheme_portfolio',
                'types' => $worktype_slugs,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'posts_per_page' => -1
            );
            query_posts($countquery);
            if (have_posts()):
                while (have_posts()):
                    the_post();
                endwhile;
            endif;
            
            if ($type == "ajax") {
                $filter_portfoliogrid .= '	<div class="ajax-gridblock-block-wrap clearfix">';
                $filter_portfoliogrid .= '	<div class="ajax-gallery-navigation clearfix">';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-next" href="#"><i class="feather-icon-arrow-right"></i></a>';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-hide" href="#"><i class="feather-icon-align-justify"></i></a>';
                $filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-prev" href="#"><i class="feather-icon-arrow-left"></i></a>';
                $filter_portfoliogrid .= '		<span class="ajax-loading">Loading</span>';
                $filter_portfoliogrid .= '	</div>';
                $filter_portfoliogrid .= '	<div class="ajax-gridblock-window">';
                $filter_portfoliogrid .= '		<div id="ajax-gridblock-wrap"></div>';
                $filter_portfoliogrid .= '	</div>';
                $filter_portfoliogrid .= '	</div>';
            }
            $filter_portfoliogrid .= '<div class="gridblock-filter-select-wrap is-animated fadeIn animation-standby">';
            
            $filter_portfoliogrid .= '<div id="gridblock-filters">';
            $filter_portfoliogrid .= '<ul class="gridblock-filter-categories">';
            
            $filter_portfoliogrid .= '<li class="filter-all-control">';
            $filter_portfoliogrid .= '<a data-filter="*" data-title="' . imaginem_codepack_get_option_data('portfolio_allitems') . '" href="#">';
            $filter_portfoliogrid .= imaginem_codepack_get_option_data('portfolio_allitems');
            $filter_portfoliogrid .= '</a>';
            $filter_portfoliogrid .= '</li>';
            
            //$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
            if ($worktype_slugs != '')
                $all_works = explode(",", $worktype_slugs);
            if ($filter_subcats == "true") {
                $categories = get_categories('orderby=slug&parent=0&taxonomy=types&title_li=');
            } else {
                $categories = get_categories('orderby=slug&taxonomy=types&title_li=');
            }
            foreach ($categories as $category) {
                
                $taxonomy = "types";
                
                // Using Term Slug
                $term_slug = $category->slug;
                $term      = get_term_by('slug', $term_slug, $taxonomy);
                
                // Enter only if Works is not set - means all included OR if work types are defined in shortcode
                if (!isSet($all_works) || in_array($term_slug, $all_works)) {
                    // Fetch the count
                    //echo $term->count;
                    if ($pagination == 'true') {
                        if (is_array($portfoliofilters)) {
                            $filter_found = false;
                            $hide_filter  = '';
                            if (in_array($category->slug, $portfoliofilters)) {
                                $filter_found = true;
                            }
                            
                        }
                        if (!$filter_found) {
                            $hide_filter = 'style="display:none;"';
                            //echo $category->slug;
                        }
                    }
                    $filter_portfoliogrid .= '<li ' . $hide_filter . ' class="filter-control filter-category-control filter-control-' . $category->slug . '">';
                    $filter_portfoliogrid .= '<a data-filter=".filter-' . $category->slug . '" data-title="' . $category->name . '" href="#">';
                    $filter_portfoliogrid .= $category->name;
                    $filter_portfoliogrid .= '</a>';
                    $filter_portfoliogrid .= '</li>';
                    
                    // Populate Subcategories
                    if ($filter_subcats == "true") {
                        $portfolio_subcategories = get_categories('orderby=slug&taxonomy=types&child_of=' . $category->term_id . '&title_li=');
                        //print_r($portfolio_subcategories);
                        foreach ($portfolio_subcategories as $portfolio_subcategory) {
                            //print_r($portfolio_subcategory->slug);
                            $subcat_filter_portfoliogrid .= '<li class="filter-' . $category->slug . '-of-parent filter-subcat-control filter-control filter-control-' . $portfolio_subcategory->slug . '">';
                            $subcat_filter_portfoliogrid .= '<a data-filter=".filter-' . $portfolio_subcategory->slug . '" data-title="' . $portfolio_subcategory->name . '" href="#">';
                            $subcat_filter_portfoliogrid .= $portfolio_subcategory->name;
                            $subcat_filter_portfoliogrid .= '</a>';
                            $subcat_filter_portfoliogrid .= '</li>';
                        }
                    }
                }
            }
            
            $filter_portfoliogrid .= '</ul>';
            
            if ($subcat_filter_portfoliogrid <> '' && $filter_subcats == "true") {
                $subcat_filter_portfoliogrid = '<ul class="griblock-filters-subcats">' . $subcat_filter_portfoliogrid . '</ul>';
            }
            $filter_portfoliogrid .= $subcat_filter_portfoliogrid;
            $filter_portfoliogrid .= '</div>';
            $filter_portfoliogrid .= '</div>';
            //End of If Filter
        }
        
        if (isSet($filter_portfoliogrid)) {
            $portfoliogrid = $filter_portfoliogrid . $portfoliogrid;
        }
        //Reset query after Filters
        
        wp_reset_query();
        return $portfoliogrid;
    }
}
add_shortcode("gridcreate", "mGridCreate");
/**
 * AJAX Flexi Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_Verticalimages($atts, $content = null)
{
    extract(shortcode_atts(array(
        "pageid" => '',
        "pb_image_ids" => '',
        "dpage" => '',
        "height" => '',
        "animation" => 'true',
        "width" => '',
        "imagesize" => 'kreativa-gridblock-full'
    ), $atts));
    
    
    if (trim($pb_image_ids) <> '') {
        $filter_image_ids = explode(',', $pb_image_ids);
    } else {
        $filter_image_ids = imaginem_codepack_get_custom_attachments($pageid);
    }
    
    $uniqurePageID  = dechex(mt_rand(1, 65535));
    $found_an_image = false;
    if ($filter_image_ids) {
        $output = '
			<ul class="vertical_images clearfix">';
        foreach ($filter_image_ids as $attachment_id) {

            $check_if_image_present = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
            //print_r($check_if_image_present); echo '------'.$attachment_id.'<br/>';
            if ( !$check_if_image_present ) {
                continue;
            }
                
            $imagearray = wp_get_attachment_image_src($attachment_id, $imagesize, false);
            $imageURI   = $imagearray[0];
            if (isSet($imageURI) && $imageURI <> "") {
                $found_an_image = true;
            }
            $imageID    = get_post($attachment_id);
            $imageTitle = "";
            if (isSet($imageID->post_title)) {
                $imageTitle = $imageID->post_title;
            }
            $imageCaption = "";
            if (isSet($imageID->post_excerpt)) {
                $imageCaption = $imageID->post_excerpt;
            }
            $fullimagearray = wp_get_attachment_image_src($attachment_id, '', false);
            $fullimageURI   = $fullimagearray[0];
            $output .= '<li class="is-animated animated fadeIn">';
            
            
            $output .= imaginem_codepack_activate_lightbox(
                $lightbox_type = "default",
                $ID = get_the_id(),
                $predefined = $fullimageURI,
                $mediatype = "image",
                $title = $imageTitle,
                $class = "vertical-images-link lightbox-image",
                $set = "vertical-images",
                $data_name = "default",
                $external_thumbnail_id = $attachment_id,
                $imageDataID=$attachment_id
            );
            $output .= '<img src="' . esc_url($imageURI) . '" alt="' . esc_attr(imaginem_codepack_get_alt_text($attachment_id)) . '" />';
            
            $output .= '</a>';
            
            if ($animation == "true") {
                $animation_classes = ' is-animated animated fadeIn';
            } else {
                $animation_classes = '';
            }
            
            if ($imageTitle <> "") {
                $output .= '<div class="vertical-images-title-wrap">';
                $output .= '<div class="vertical-images-title' . $animation_classes . '">' . $imageTitle . '</div>';
                $output .= '</div>';
            }
            $output .= '</li>';
        }
        $output .= '</ul>';
        if ($found_an_image) {
            return $output;
        } else {
            return false;
        }
    }
}
add_shortcode("vertical_images", "mtheme_Verticalimages");

add_shortcode("portfolio_details", "mtheme_portfolio_details");
function mtheme_portfolio_details($atts, $content = null)
{
    extract(shortcode_atts(array(
        "project_title" => '',
        "like" => 'no',
        "alignment" => '',
        "project_detail_title" => '',
        "project_client_title" => '',
        "project_client_target" => '',
        "project_link_target" => '',
        "project_client" => '',
        "project_client_link" => '',
        "project_skills" => '',
        "project_link_title" => '',
        "project_link" => ''
    ), $atts));
    
    $content = wpautop(html_entity_decode($content));
    
    $project_skills = explode(',', $project_skills);
    shuffle($project_skills);
    $skills_html = '<ul>';
    foreach ($project_skills as $p_skill) {
        $skills_html .= '<li>' . $p_skill . '</li>';
    }
    $skills_html .= '</ul>';
    
    if ($alignment == "center") {
        $alignment_class = "center";
    }
    if ($alignment == "right") {
        $alignment_class = "right";
    }
    if ($alignment == "left") {
        $alignment_class = "left";
    }

    $project_target_tag = '';
    $client_target_tag = '';

    if ($project_link_target=="yes") {
        $project_target_tag = 'target="_blank"';
    }
    if ($project_client_target=="yes") {
        $client_target_tag = 'target="_blank"';
    }
    
    $output = '<div class="portfolio-details-section-inner portfolio-details-align-' . $alignment . ' entry-content portfolio-header-right-inner">';
    $output .= '<h2 class="project-heading">' . $project_title . '</h2>';
    $output .= '<div class="portfolio-content-summary entry-content">' . $content . '</div>';
    $output .= '<div class="portfolio-details-wrap">';
    $output .= '<div class="portfolio-details-inner">';
    $output .= '<div class="project-details project-info project-skills-column">';
    $output .= '<h4>Skills</h4>';
    $output .= $skills_html;
    $output .= '</div>';
    if ( $project_link_title<>"" ) {

        $project_link_start = '';
        $project_link_end = '';
        $project_link_icon = '<i class="feather-icon-minus"></i>';
        if ( $project_link<>"" ) {
            $project_link_icon = '<i class="feather-icon-link"></i>';
            $project_link_start = '<a '.$project_target_tag.' href="'.esc_url($project_link).'">';
            $project_link_end = '</a>';
        }

        $output .= '<div class="project-details-link clear">';
        $output .= $project_link_icon;
        $output .= '<h4>'.$project_link_start. $project_link_title . $project_link_end. '</h4>';
        $output .= '</div>';
    }
    if ( $project_client<>"" ) {

        $client_link_start = '';
        $client_link_end = '';
        $client_link_icon = '<i class="feather-icon-minus"></i>';
        if ( $project_client_link<>"" ) {
            $client_link_icon = '<i class="feather-icon-link"></i>';
            $client_link_start = '<a '.$client_target_tag.' class="client-link" href="' . $project_client_link . '">';
            $client_link_end = '</a>';
        }

        $output .= '<div class="project-details-link clear">';
        $output .= $client_link_icon;
            $output .= '<h4>'.$client_link_start.'<span>' . $project_client . '</span>'.$client_link_end.'</h4>';
        $output .= '</div>';
    }
    if ($like == "yes") {
        $output .= kreativa_display_like_link(get_the_id());
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
    
}

/**
 * Portfolio Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_PortfolioParallax($atts, $content = null)
{
    extract(shortcode_atts(array(
        "limit" => '-1',
        "worktype_slugs" => '',
        'height_type' => 'fixed',
        "height" => '300'
    ), $atts));
    
    if ($limit == '') {
        $limit = "-1";
    }
    
    $count = 0;
    
    //echo $type, $portfolio_type;
    $countquery = array(
        'post_type' => 'mtheme_portfolio',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'types' => $worktype_slugs,
        'posts_per_page' => $limit
    );
    query_posts($countquery);
    
    $portfolioImage_type = "kreativa-gridblock-full";
    $output              = '<div class="gridblock-parallax-wrap clearfix">';
    $output .= '<ul>';
    
    $height_class = '';
    if ($height == 0 || $height_type == "window") {
        $height       = '100%;';
        $height_class = ' fullheight-parallax';
    } else {
        $height = $height . 'px';
    }
    
    if (have_posts()):
        while (have_posts()):
            the_post();
            
            if (has_post_thumbnail()) {
                
                $image_id  = get_post_thumbnail_id(get_the_ID(), $portfolioImage_type);
                $image_url = wp_get_attachment_image_src($image_id, $portfolioImage_type);
                $image_url = $image_url[0];
                $img_obj   = get_post($image_id);
                $img_alt   = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                
                $lightbox_image = imaginem_codepack_featured_image_link(get_the_id());
                $lightbox_media = $lightbox_image;
                $custom         = get_post_custom(get_the_ID());
                
                $description    = "";
                $customlink_URL = "";
                
                if (isset($custom['pagemeta_thumbnail_desc'][0])) {
                    $description = $custom['pagemeta_thumbnail_desc'][0];
                }
                if (isset($custom['pagemeta_customlink'][0])) {
                    $customlink_URL = $custom['pagemeta_customlink'][0];
                }
                
                $count++;
                //$fadeinstyle ="fadeInLeft";
                $fadeinstyle = "fadeIn";
                // if ($count % 2 == 0) {
                // 	$fadeinstyle ="fadeInRight";
                // }
                
                $output .= '<li class="animation-standby animated animation-1-5-sec ' . $fadeinstyle . ' portfolio-parallax-image' . $height_class . '" style="height:' . $height . ';background-image:url(' . esc_url($image_url) . ');">';
                
                $output .= '<div class="slideshow-box-info work-details">';
                $portfolio_link = get_permalink();
                if (isSet($customlink_URL) && $customlink_URL <> "") {
                    $portfolio_link = $customlink_URL;
                }
                $output .= '<a href="' . esc_url($portfolio_link) . '">';
                $output .= '<div class="work-details">';
                $output .= '<h4 class="slideshow-box-title">' . get_the_title() . '</h4>';
                $output .= '<div class="slideshow-box-categories">';
                $categories = get_the_term_list(get_the_id(), 'types', '', ' , ', '');
                $categories = strip_tags($categories);
                $output .= $categories;
                $output .= '</div>';
                if ($description <> "") {
                    $output .= '<p class="entry-content work-description">' . $description . '</p>';
                }
                $output .= '</div>';
                $output .= '</a>';
                $output .= '</div>';
                
                $output .= '</li>';
            }
        endwhile;
    endif;
    $output .= '</ul>';
    $output .= '</div>';
    
    wp_reset_query();
    return $output;
    
    
}
add_shortcode("recent_portfolio_parallax", "mtheme_PortfolioParallax");
?>