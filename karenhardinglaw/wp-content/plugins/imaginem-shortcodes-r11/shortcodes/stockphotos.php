<?php
// Search Image Tags
if (!function_exists('mTheme_StockPhotos')) {
    function mTheme_StockPhotos($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "size" => 'thumbnail',
            "display_search_form" => 'true',
            "searchtag" => '',
            "like" => 'yes',
            "image" => '',
            "results" => 'true',
            "term_archive" => '',
            "display_stocktags" => 'false',
            "display_popular" => 'false',
            "exclude_featured" => 'false',
            "attachment_linking" => 'false',
            "title" => '',
            "titlecolor" => '',
            "filter" => '',
            "pagination" => 'true',
            "format" => '',
            "filterall" => 'All',
            "start" => '',
            "end" => '',
            "text_intensity" => 'bright',
            "linktype" => 'lightbox',
            "animated" => 'false',
            "gutter" => 'spaced',
            "boxtitle" => '',
            "limit" => '12',
            "pb_image_ids" => '',
            "columns" => '4',
            "description" => "false",
            "id" => '1',
            "pageid" => ''
        ), $atts));

        $display_stocktags = imaginem_codepack_get_option_data('stockphoto_display_tags');
        if ($display_stocktags=="") {
            $display_stocktags = "false";
        }
        $like = imaginem_codepack_get_option_data('stockphoto_enable_likes');
        if ($like=="") {
            $like = "true";
        }

        $pagination = "true";
        
        $display_search_form = "true";
        $input_sort = "0";
        $term_list  = '';
        $thumbnails = '';
        $input_type = "1";
        $input_format = "1";
        $input_column = "4";
        $extra_msg = '';


        $like = imaginem_codepack_get_option_data('stockphoto_enable_likes');
        if ($like=="true") {
            $like = "yes";
        } else {
            $like = "no";
        }
        $format = imaginem_codepack_get_option_data('stockphoto_format');
        $linktype = imaginem_codepack_get_option_data('stockphoto_link');
        $columns = imaginem_codepack_get_option_data('stockphoto_columns');

        if (kreativa_is_in_demo()) {
            if ( false != kreativa_demo_get_data('stockphotoformat') ) {
                $format = kreativa_demo_get_data('stockphotoformat');
            }
        }
        if (kreativa_is_in_demo()) {
            if ( false != kreativa_demo_get_data('stockphotolink') ) {
                $linktype = kreativa_demo_get_data('stockphotolink');
            }
        }
        if (kreativa_is_in_demo()) {
            if ( false != kreativa_demo_get_data('stockphotocolumns') ) {
                $columns = kreativa_demo_get_data('stockphotocolumns');
            }
        }
        // Set a default
        $column_type         = "four";
        $portfolioImage_type = "kreativa-gridblock-large";
        
        if ($columns == 4) {
            $input_column = "4";
            $column_type         = "four";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 3) {
            $input_column = "3";
            $column_type         = "three";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 2) {
            $input_column = "2";
            $column_type         = "two";
            $portfolioImage_type = "kreativa-gridblock-large";
        }
        if ($columns == 1) {
            $input_column = "1";
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
            $input_format = 2;
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
            $input_format = 3;
        }
        if ($format == "portrait") {
            $protected_placeholder = '/images/blank-grid-portrait.png';
        } else {
            $protected_placeholder = '/images/blank-grid.png';
        }
                
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

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
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

        $limit = imaginem_codepack_get_option_data('stockphoto_limit');
        if ($limit=="") {
            $limit = "12";
        }
        

        $default_query = false;
        if (!isSet( $_GET['photostock'] ) && !is_tax() ) {
            $default_query = true;
            // Initial set
            $stock_query = array(
                'post_type' => 'attachment',
                'order' => 'DESC',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'operator' => 'EXISTS'
                    )
                )
            );
            query_posts( $stock_query );
        }
        $display_popular="false";
        if ( $display_popular=="true" ) {
            $default_query = true;

            $stock_query = array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'meta_key' => 'votes_count',
                'orderby' => 'meta_value',
                'order' => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'operator' => 'EXISTS'
                    )
                )
            );
            query_posts( $stock_query );
        }
        if ( $results == "false" ) {
            $default_query = true;

            $stock_query = array(
                'post_type' => 'attachment',
                'order' => 'DESC',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'operator' => 'EXISTS'
                    )
                )
            );
            query_posts( $stock_query );
        }
            
        if ( isSet($term_archive) && $term_archive<>"" ) {
            $default_query = true;

            $stock_query = array(
                'post_type' => 'attachment',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'field' => 'slug',
                        'terms' => $term_archive,
                        'operator' => 'IN'
                    )
                )
            );
            
            query_posts( $stock_query );
        }
            
            $thumbnails .= '<div class="stockphotos thumbnails-shortcode gridblock-columns-wrap clearfix">';
            $thumbnails .= '<div class="thumbnails-grid-container thumbnail-gutter-' . $gutter . $gridblock_is_masonary . $thumbnail_gutter_class . $title_desc_class . $boxtitle_class . ' gridblock-' . $column_type . '" data-columns="' . $columns . '">';
            
            //foreach ($query_images->posts as $image) {
            //
            if ( have_posts() ) while ( have_posts() ) : the_post();
                
                $attachment_id = get_the_id();
                
                $thumbnailcount++;
                $filter_attribute = '';
                // echo '<pre>';
                // print_r($filterable_tags);
                // echo '</pre>';
                
                $imagearray = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                $imageURI   = $imagearray[0];
                
                $thumbnail_imagearray = wp_get_attachment_image_src($attachment_id, $portfolioImage_type, false);
                $thumbnail_imageURI   = $thumbnail_imagearray[0];
                
                $imageTitle = '';
                $imageDesc  = '';
                $imageID    = get_post($attachment_id);
                $link_url   = get_post_meta($attachment_id, 'mtheme_attachment_fullscreen_url', true);
                $purchase_url   = get_post_meta($attachment_id, 'mtheme_attachment_purchase_url', true);
                
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
                //  $thumbnails .=   '<li class="clearfix"></li>';
                // }
                $animation_class = '';
                if ($animated == "true") {
                    //$animation_class=' animation-standby animated rotateInUpRight';
                    $animation_class = ' animation-standby animated fadeIn';
                }
                $thumbnails .= '<div class="gridblock-element ' . $animation_class . ' gridblock-thumbnail-id-' . $attachment_id . ' gridblock-col-' . $portfolio_count . $filter_attribute . '">';
                
                $thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="' . get_the_id() . '">';

                if ($like == "yes") {
                    $thumbnails .= '<div class="mtheme-post-like-wrap">';
                    $thumbnails .= kreativa_display_like_link(get_the_id());
                    $thumbnails .= '</div>';
                }

                if (!isSet($linktype)) {
                    $linktype = "lightbox";
                }

                switch ( $linktype ) {
                    case 'lightbox':
                        $input_type = "1";
                        break;
                    case 'download':
                        $input_type = "2";
                        break;
                    case 'purchase':
                        $input_type = "3";
                        break;
                    case 'url':
                        $input_type = "4";
                        break;
                    
                    default:
                        $input_type = "1";
                        break;
                }

                $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');
                
                $thumbnails .= '<div class="gridblock-background-hover">';
                
                $links_tag_added = false;
                if ($linktype == "download") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                    $thumbnails .= '</a>';
                    $links_tag_added = true;
                }
                if ($linktype == "purchase") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                    $thumbnails .= '</a>';
                    $links_tag_added = true;
                }
                if ($linktype == "url") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                    $thumbnails .= '</a>';
                    $links_tag_added = true;
                }
                
                if ($linktype == "lightbox") {
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');
                    $url_linked     = false;
                }
                if ($linktype == "url") {
                    if (isSet($link_url) && $link_url <> "") {
                        $thumbnails .= '<a href="' . esc_url($link_url) . '" data-title="' . esc_attr($imageTitle) . '">';
                    }
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('link');
                    $url_linked     = true;
                }
                if ($linktype == "download") {
                    $thumbnails .= '<a href="' . esc_url($imageURI) . '" data-title="' . esc_attr($imageTitle) . '" download>';
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('download');
                    $url_linked     = true;
                }
                if ($linktype == "purchase") {
                    $thumbnails .= '<a href="' . esc_url($purchase_url) . '" data-title="' . esc_attr($imageTitle) . '">';
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('purchase');
                    $url_linked     = true;
                }
                
                if ( !$links_tag_added ) {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                }
                
                if ($attachment_linking == "true") {
                    $thumbnails .= '<a class="column-gridblock-icon" href="' . get_attachment_link($attachment_id) . '">';
                    $thumbnails .= '<span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('directlink') . '"></i></span>';
                    $thumbnails .= '</a>';
                }
                
                $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . $thumbnail_icon . '"></i></span></span>';
                
                $thumbnails .= '</div>';
                if ($boxtitle == "true") {
                    $thumbnails .= '<span class="boxtitle-hover">';
                    $thumbnails .= '<span class="shortcode-box-title">';
                    $thumbnails .= $imageTitle;
                    $thumbnails .= '</span>';
                    $thumbnails .= '</span>';
                }
                $thumbnails .= '</div>';
                $thumbnails .= '</a>';
                $thumbnails .= '<img class="preload-image displayed-image" src="' . $thumbnail_imagearray[0] . '" alt="' . imaginem_codepack_get_alt_text($attachment_id) . '">';
                
                $thumbnails .= '</div>';
                $thumbnails .= '</div>';
            endwhile;

            $thumbnails .= '</div>';
            $thumbnails .= '</div>';
            
            if ($pagination == 'true') {
                $thumbnails .= '<div class="clearfix">';
                $thumbnails .= imaginem_codepack_pagination();
                $thumbnails .= '</div>';
            }

        if ($display_stocktags=="true") {
            $term_args = array(
                'hide_empty' => 1
            );
            
            $allterms = get_terms('phototag', $term_args);
            if (!empty($allterms) && !is_wp_error($allterms)) {
                $count     = count($allterms);
                $i         = 0;
                $term_list = '<ul class="phototag-archive-list">';
                foreach ($allterms as $term) {
                    $i++;
                    $tag_url = get_term_link($term);
                    $term_list .= '<li><a href="' . esc_url(  $tag_url ) . '"><span class="phototag-hash">#</span>' . $term->name . '</a></li>';
                }
                $term_list .= '</ul>';
            }
        }


        wp_reset_query();

        $search_query = '';
        $searchform = '';
        if ($display_search_form == "true") {

            if ( is_search() ) {
                $term_archive = get_search_query();
            }

            if ( $results<>"false") {
                if ( $term_archive=="" ) {
                    $searchform .= '<div class="section-heading animated fadeInUp section-align-center animation-action">';
                    $searchform .= '<h1 class="entry-title section-title">'.$title.'</h1>';
                    $searchform .= '<div class="section-description section-style-none">';
                        $searchform .= '<p>'.wpautop( html_entity_decode($description) ).'</p>';
                    $searchform .= '</div>';
                    $searchform .= '</div>';
                } else {
                    if ($term_archive<>"") {
                        $searchform .= '<div class="section-heading animated fadeInUp section-align-center animation-action">';
                        $searchform .= '<h1 class="entry-title section-title">'.$term_archive.'</h1>';
                        $searchform .= '</div>';
                    }
                }
            } else {

                if ($term_archive<>"") {
                    $searchform .= '<div class="section-heading animated fadeInUp section-align-center animation-action">';
                    $searchform .= '<h1 class="entry-title section-title">'.$term_archive.'</h1>';
                    $searchform .= '</div>';
                }

                $noimage_msg =imaginem_codepack_get_option_data('stockphoto_noimages');
                $extra_msg_text =imaginem_codepack_get_option_data('stockphoto_noimages_extra');
                if ($noimage_msg=="") {
                    $noimage_msg= "No Image found for your search term!";
                }
                if ($extra_msg_text=="") {
                    $extra_msg= "Here are some images you might find useful.";
                }
                $extra_msg = '<h2 class="secondary-not-found-msg">'.$extra_msg_text.'</h2>';
                $searchform .= '<div class="section-heading animated fadeInUp section-align-center animation-action">';
                $searchform .= '<h1 class="primary-not-found-msg">'.$noimage_msg.'</h1>';
                $searchform .= '</div>';                
            }

            $searchform .= '<div class="photostock-search-form">';
            $searchform .= '<form method="get" id="searchform" action="'.esc_url( home_url( '/' ) ).'">';
            ob_start();
            get_template_part( 'searchform', 'images' );
            $searchform .= ob_get_clean();
            $searchform .= '</form>';
            $searchform .= '</div>';
        }

        $background_image_tag = '';
        if ($image<>"") {
            $background_image_tag = 'style="background-image: url('.esc_url($image).');"';    
        }
        
        $parallax_tag_start = '<div class="stockheader-wrap stockphotos-background header-parallax text-is-'.$text_intensity.' mtheme-modular-column modular-column-parallax" '.$background_image_tag.'>';
        $parallax_tag_end = '</div>';

        $thumbnails = $parallax_tag_start . $searchform . $term_list . $extra_msg . $parallax_tag_end . $thumbnails;


        return $thumbnails;
    }
}
add_shortcode("display_stockphotos", "mTheme_StockPhotos");
// Search Image Tags
if (!function_exists('mTheme_Search_Image_Tags')) {
    function mTheme_Search_Image_Tags($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "size" => 'thumbnail',
            "display_search_form" => 'false',
            "searchtag" => '',
            "exclude_featured" => 'false',
            "attachment_linking" => 'false',
            "filter" => '',
            "pagination" => 'false',
            "format" => '',
            "filterall" => 'All',
            "start" => '',
            "end" => '',
            "linktype" => 'lightbox',
            "animated" => 'false',
            "gutter" => 'spaced',
            "boxtitle" => '',
            "limit" => '-1',
            "pb_image_ids" => '',
            "columns" => '4',
            "title" => "false",
            "description" => "false",
            "id" => '1',
            "pageid" => ''
        ), $atts));
        
        $term_list  = '';
        $thumbnails = '';
        
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
        
        $searchform = '';
        if ($display_search_form == "true") {
            $searchform = '<div class="contents-wrap fullwidth">
            <form method="get" id="searchform" action="' . esc_url(home_url('/')) . '">
            <input type="text" value="" name="s" id="s" class="right" />
            <input class="button" type="hidden" name="photostock" value="1" />
            <button class="ntips" id="searchbutton" type="submit"><i class="fa fa-search"></i></button>
            </form>
            </div>';
        }
        
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
        
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        
        $terms = explode(' ', $searchtag);
        
        //$terms = $searchtag;
        
        if (isSet($terms) && $terms <> "") {
            $query_images_args = array(
                'post_type' => 'attachment',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'field' => 'slug',
                        'terms' => $terms,
                        'operator' => 'IN'
                    )
                )
            );
        } else {
            $query_images_args = array(
                'post_type' => 'attachment',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'post_mime_type' => 'image',
                'post_status' => 'published',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'phototag',
                        'operator' => 'EXISTS'
                    )
                )
            );
        }
        // Custom query.
        $query_images = new WP_Query($query_images_args);
        
        if ($query_images->have_posts()) {
            
            $thumbnails .= '<div class="thumbnails-shortcode gridblock-columns-wrap clearfix">';
            $thumbnails .= '<div class="thumbnails-grid-container thumbnail-gutter-' . $gutter . $gridblock_is_masonary . $thumbnail_gutter_class . $title_desc_class . $boxtitle_class . ' gridblock-' . $column_type . '"  data-columns="' . $columns . '">';
            
            foreach ($query_images->posts as $image) {
                
                $attachment_id = $image->ID;
                
                $thumbnailcount++;
                $filter_attribute = '';
                // echo '<pre>';
                // print_r($filterable_tags);
                // echo '</pre>';
                
                $imagearray = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                $imageURI   = $imagearray[0];
                
                $thumbnail_imagearray = wp_get_attachment_image_src($attachment_id, $portfolioImage_type, false);
                $thumbnail_imageURI   = $thumbnail_imagearray[0];
                
                $imageTitle = '';
                $imageDesc  = '';
                $imageID    = get_post($attachment_id);
                $link_url   = get_post_meta($attachment_id, 'mtheme_attachment_fullscreen_url', true);
                
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
                //  $thumbnails .=   '<li class="clearfix"></li>';
                // }
                $animation_class = '';
                if ($animated == "true") {
                    //$animation_class=' animation-standby animated rotateInUpRight';
                    $animation_class = ' animation-standby animated fadeIn';
                }
                $thumbnails .= '<div class="gridblock-element ' . $animation_class . ' gridblock-thumbnail-id-' . $attachment_id . ' gridblock-col-' . $portfolio_count . $filter_attribute . '">';
                
                $thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="' . get_the_id() . '">';
                
                if (!isSet($linktype)) {
                    $linktype = "lightbox";
                }
                $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');
                
                $thumbnails .= '<div class="gridblock-background-hover">';
                
                if ($linktype == "download") {
                    $thumbnails .= '<div class="gridblock-links-wrap">';
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . imaginem_codepack_get_portfolio_icon('lightbox') . '"></i></span></span>';
                    $thumbnails .= '</a>';
                }
                
                if ($linktype == "lightbox") {
                    $thumbnails .= imaginem_codepack_activate_lightbox($lightbox_type = "default", $ID = get_the_id(), $predefined = $imageURI, $mediatype = "image", $imagetitletag = $imageTitle, $class = "lightbox-image", $set = "thumbnails-grid", $data_name = "default");
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('lightbox');
                    $url_linked     = false;
                }
                if ($linktype == "url") {
                    if (isSet($link_url) && $link_url <> "") {
                        $thumbnails .= '<a href="' . esc_url($link_url) . '" data-title="' . esc_attr($imageTitle) . '">';
                    }
                    $thumbnail_icon = imaginem_codepack_get_portfolio_icon('link');
                    $url_linked     = true;
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
                
                $thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="' . $thumbnail_icon . '"></i></span></span>';
                
                $thumbnails .= '</div>';
                if ($boxtitle == "true") {
                    $thumbnails .= '<span class="boxtitle-hover">';
                    $thumbnails .= '<span class="shortcode-box-title">';
                    $thumbnails .= $imageTitle;
                    $thumbnails .= '</span>';
                    $thumbnails .= '</span>';
                }
                $thumbnails .= '</div>';
                $thumbnails .= '</a>';
                $thumbnails .= '<img class="preload-image displayed-image" src="' . $thumbnail_imagearray[0] . '" alt="' . imaginem_codepack_get_alt_text($attachment_id) . '">';
                
                $thumbnails .= '</div>';
                $thumbnails .= '</div>';
            }
            $thumbnails .= '</div>';
            $thumbnails .= '</div>';
            
            if ($pagination == 'true') {
                $thumbnails .= '<div class="clearfix">';
                $thumbnails .= imaginem_codepack_pagination($query_images->max_num_pages, $range = 4);
                $thumbnails .= '</div>';
            }
            
            wp_reset_query();
        }
        $term_args = array(
            'hide_empty' => 1
        );
        
        $allterms = get_terms('phototag', $term_args);
        if (!empty($allterms) && !is_wp_error($allterms)) {
            $count     = count($allterms);
            $i         = 0;
            $term_list = '<div class="phototag-archive-list">';
            foreach ($allterms as $term) {
                $i++;
                $term_list .= '<a href="' . get_term_link($term) . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a>';
                if ($count != $i) {
                    $term_list .= ' &middot; ';
                } else {
                    $term_list .= '</div>';
                }
            }
        }
        return $searchform . $term_list . $thumbnails;
    }
}
add_shortcode("search_image_tags", "mTheme_Search_Image_Tags");
?>