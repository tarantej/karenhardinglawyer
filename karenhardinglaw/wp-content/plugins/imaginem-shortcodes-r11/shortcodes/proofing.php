<?php
//Thumbnails for Gallery [thumbnails]
if ( !function_exists( 'mtheme_Proofing' ) ) {
	function mtheme_Proofing($atts, $content = null) {
		extract(shortcode_atts(array(
			"size" => 'thumbnail',
			"exclude_featured" => 'false',
			"attachment_linking" => 'false',
			"format" => '',
			"start" => '',
			"end" => '',
			"animated" => 'true',
			"gutter" => 'spaced',
			"boxtitle" => '',
			"pb_image_ids" => '',
			"columns" => '4',
			"title" => "true",
			"description" => "false",
			"id" => '1',
			"proofingstatus" => 'active',
			"pageid" => ''
		), $atts));
		
	// Set a default
	$column_type="four";
	$portfolioImage_type="kreativa-gridblock-large";

    $animation_class = '';
    if ($animated == "true") {
        $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
        if ($format == "masonary" ) {
            $animation_class = ' grid-animate-display-all';
        }
    }

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="kreativa-gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = " gridblock-masonary";
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}
	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/blank-grid.png';
	}
	$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
		
		$portfolio_count=0;
		$thumbnailcount=0;
		$thepageID=get_the_id();

		$pb_image_ids=trim($pb_image_ids);
		if ( !empty($pb_image_ids) ) {
			$filter_image_ids = explode(',', $pb_image_ids);
		} else {
			if ( $pageid == '') {
				$pageid = get_the_id();
			}
			$filter_image_ids = imaginem_codepack_get_custom_attachments ( $pageid );
		}

		if ($end < $start) {
			$end='';
			$start='';
		}

		$thumbnail_gutter_class='';
		if ($gutter=="nospace") {
			$thumbnail_gutter_class = ' thumnails-gutter-active ';
		}

		$title_desc_class = '';
		if ($title=="false" && $description=="false") {
			$title_desc_class = " no-title-no-desc";
		}

		$proof_edit_enabled = $proofingstatus;

		//$filter_image_ids = imaginem_codepack_get_custom_attachments ( $thepageID );
		
		if ( $filter_image_ids ) {


			
				$thumbnails =  '<div class="proofing-shortcode proofing-status-'.$proofingstatus.' thumbnails-shortcode clearfix">';
			// Filterables
		$thumbnails .= '<div class="gridblock-header-wrap">';
		$thumbnails .= '<div class="gridblock-filter-select-wrap">';

			$thumbnails .= '<div id="gridblock-filters">';
				$thumbnails .= '<ul class="gridblock-filter-categories">';
					
					$thumbnails .= '<li class="filter-all-control">';
						$thumbnails .= '<a data-filter="*" data-title="All items" href="#">';
						$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>All items';
						$thumbnails .= '</a>';
					$thumbnails .= '</li>';

					$thumbnails .= '<li class="filter-control filter-category-control filter-control-selected">';
						$thumbnails .= '<a data-filter=".filter-selected" data-title="Selected" href="#">';
							$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>Selected';
						$thumbnails .= '</a>';
					$thumbnails .= '</li>';

					$thumbnails .= '<li class="filter-control filter-category-control filter-control-rejected">';
						$thumbnails .= '<a data-filter=".filter-unchecked" data-title="Rejected" href="#">';
							$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>Rejected';
						$thumbnails .= '</a>';
					$thumbnails .= '</li>';

					$thumbnails .= '</ul>';
				$thumbnails .= '</div>';
			$thumbnails .= '</div>';

				// Selected Count
				$thumbnails .=  '<div class="proofing-status-count-wrap"><div id="proofing-status-count" class="is-animated animated fadeIn"><span class="proofing-count-selected">0</span> / <span class="proofing-count-total">0</span> ' . __('Selected','mthemelocal') . '</div></div>';

			$thumbnails .= '</div>';

				$thumbnails .= '<div class="gridblock-columns-wrap">';
				$thumbnails .= '<div id="gridblock-container" class="proofing-item-wrap thumbnails-grid-container thumbnail-gutter-'.$gutter.$gridblock_is_masonary.$thumbnail_gutter_class.$title_desc_class.' gridblock-'.$column_type.'"  data-columns="'.$columns.'">';

				$featuredID = get_post_thumbnail_id();

				foreach ( $filter_image_ids as $attachment_id) {


                $check_if_image_present = wp_get_attachment_image_src($attachment_id, 'fullsize', false);
                //print_r($check_if_image_present); echo '------'.$attachment_id.'<br/>';
                if ( !$check_if_image_present ) {
                    continue;
                }
				
				$thumbnailcount++;
				
				if ($start!='') {
					if ($thumbnailcount < $start ) { continue; }
				}
				if ($end!='') {
					if ($thumbnailcount > $end ) { continue; }
				}

				if ( $exclude_featured=='true') {
					if ($featuredID==$attachment_id) continue; // skip rest of the loop
				}

				$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
				$imageURI = $imagearray[0];			
				
				$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
				$thumbnail_imageURI = $thumbnail_imagearray[0];
				
				$imageTitle='';
				$imageDesc='';
				$imageID = get_post($attachment_id);
				if (isSet( $imageID->post_title ) ) {
					$imageTitle = $imageID->post_title;
				}
				if (isSet( $imageID->post_content ) ) {
					$imageDesc= $imageID->post_content;
				}
				
				if ($portfolio_count==$columns) $portfolio_count=0;
				$portfolio_count++;

				// if ($portfolio_count==1) {
				// 	$thumbnails .=   '<li class="clearfix"></li>';
				// }

				$mtheme_proofing_status="false";
				$proofing_icon=imaginem_codepack_get_portfolio_icon('proofing-check');
				$set_proofing="unchecked";

				$mtheme_proofing_status = get_post_meta($attachment_id,'checked',true);
				if ($mtheme_proofing_status=="true") {
					$set_proofing="selected";
					$proofing_icon=imaginem_codepack_get_portfolio_icon('proofing-cross');
				}

				$thumbnails .=  '<div id="mtheme-proofing-item-'.$attachment_id.'" data-proofing_status="'.$set_proofing.'" class="filter-'.$set_proofing.' mtheme-proofing-item proofing-item-'.$set_proofing.' isotope-displayed gridblock-element '.$animation_class.' gridblock-thumbnail-id-'.$attachment_id.' gridblock-col-'.$portfolio_count.'">';
				$thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="'.get_the_id().'">';
					$thumbnails .= '<i class="proofing-progress-indicator fa fa-circle-o-notch"></i>';
					$thumbnails .= '<span class="proofing-selected-marker"><i class="'.imaginem_codepack_get_portfolio_icon('selected').'"></i></span>';
					if ($proofingstatus<>"active") {
						$thumbnails .= imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=$imageURI,
									$mediatype="image",
									$imagetitle='ID'.$attachment_id.' '.$imageTitle,
									$class="column-gridblock-lightbox lightbox-image",
									$set="metro-grid",
									$data_name="default",
									$external_thumbnail_id = $attachment_id,
									$imageDataID=$attachment_id
								);
					}
					$thumbnails .= '<div class="gridblock-background-hover">';
						$thumbnails .= '<div class="gridblock-links-wrap">';
					
						if ($proofingstatus=="active") {
							$thumbnails .=  imaginem_codepack_activate_lightbox (
								$lightbox_type="default",
								$ID='',
								$link=$imageURI,
								$mediatype="image",
								$imagetitle='ID'.$attachment_id.' '.$imageTitle,
								$class="column-gridblock-icon column-gridblock-lightbox",
								$set="metro-grid",
								$data_name="default",
								$external_thumbnail_id = $attachment_id,
								$imageDataID=$attachment_id
								);
								$thumbnails .= '<span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i></span>';
							$thumbnails .= '</a>';
							
							$thumbnails .= '<a class="column-gridblock-icon mtheme-proofing-choice mtheme-proofing-'.$proof_edit_enabled.'" data-image_id="'.$attachment_id.'">';
								$thumbnails .= '<span class="hover-icon-effect"><i class="proofing-icon-status '.$proofing_icon.'"></i></span>';
							$thumbnails .= '</a>';
							$thumbnails .= '<a download href="'.$imageURI.'" class="column-gridblock-icon column-gridblock-lightbox">';
								$thumbnails .= '<span class="hover-icon-effect"><i class="proofing-icon-download '.imaginem_codepack_get_portfolio_icon('download').'"></i></span>';
							$thumbnails .= '</a>';
						} else {
							$thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i></span></span>';
						}

						$thumbnails .= '</div>';
					$thumbnails .= '</div>';
			if ($proofingstatus<>"active") {
				$thumbnails .= '</a>';
			}
			$thumbnails .= '<img class="preload-image displayed-image" src="'.$thumbnail_imagearray[0].'" alt="'.imaginem_codepack_get_alt_text($featuredID).'">';
			$thumbnails .=  '</div>';
			if ($title=="true" || $description=="true") {
				$portfoliogrid ='<div class="work-details">';
					if ($title=='true') {

						$theimagetitle = '#'. $attachment_id;
						$proofing_title_type=imaginem_codepack_get_option_data('proofing_image_id');
						if ($proofing_title_type=="filename") {
							$theimagetitle = basename( get_attached_file( $attachment_id ) );
						}
						if ($proofing_title_type=="imagetitle") {
							$theimagetitle = $imageTitle;
						}

						$portfoliogrid .= '<h4>';
						$portfoliogrid .= $theimagetitle;
						$portfoliogrid .= '</h4>';
					}
					if ($description=='true') { $portfoliogrid .= '<p class="entry-content work-description">'.$imageDesc.'</p>'; }
				$portfoliogrid .='</div>';
				$thumbnails .= $portfoliogrid;
			}
			$thumbnails .= '</div>';
		}
		$thumbnails .= '</div>';
		$thumbnails .= '</div>';
		$thumbnails .= '</div>';

		return $thumbnails;

		}	
	}
}
add_shortcode("proofing_gallery", "mtheme_Proofing");
/**
 * Client Grid
 */
if ( !function_exists( 'mClientGrids' ) ) {
	function mClientGrids($atts, $content = null) {
		extract(shortcode_atts(array(
			"client_id" => '',
			"pageid" => '',
			"format" => '',
			"columns" => '4',
			"animated" => 'true',
			"limit" => '-1',
			"filter_subcats" => "true",
			"category_display" => "true",
			"gutter" => 'spaced',
			"boxtitle" => 'false',
			"title" => 'true',
			"desc" => 'true',
			"worktype_slugs" => '',
			"pagination" => 'false',
			"type" => 'filter'
		), $atts));

    if ($animated == "true") {
        $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
    }

	$portfoliogrid ='';
	$subcat_filter_portfoliogrid = '';

	// Set a default
	$column_type="four";
	$portfolioImage_type="kreativa-gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="kreativa-gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = "gridblock-masonary ";
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}

	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
	$thumbnail_gutter_class =  'portfolio-gutter-'.$gutter.' ';
	if ($gutter=="nospace") {
		$thumbnail_gutter_class .=  'thumnails-gutter-active ';
	}
	if ($title<>"true" && $desc<>"true") {
		$thumbnail_gutter_class .=  'no-title-no-desc ';
	}
	$boxtitle_class='';
	if ($boxtitle=="true") {
		$boxtitle_class=" boxtitle-active";
	}
	$flag_new_row=true;


	$portfoliogrid .= '<div id="gridblock-container" class="'.$thumbnail_gutter_class.$gridblock_is_masonary.$boxtitle_class.' gridblock-'.$column_type.' clearfix" data-columns="'.$columns.'">';

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	$count=0;
	$terms=array();
	$work_slug_array=array();

	$current_page_id = get_the_id();

	query_posts(
		array(
			'post_type' => 'mtheme_proofing',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'paged' => $paged,
			'posts_per_page' => $limit,
			'meta_query' => array(
	            array(
	                'key' => 'pagemeta_client_names',
	                'value' => $client_id,
	                'compare' => '='
	           	)
	        )
        )
    );

	$idCount=1;
	$portfolio_count=0;
	$portfolio_total_count=0;
	$portfoliofilters = array();

	if (have_posts()) : while (have_posts()) : the_post();
			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$description="";
		$portfolio_link_type="";
		$portfolio_thumb_header="Image";
		$the_only_link = false;
		$the_protected_link = false;

		if ( isset($custom['pagemeta_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom['pagemeta_thumbnail_linktype'][0]; }
		if ( isset($custom['pagemeta_lightbox_video'][0]) ) { $lightboxvideo=$custom['pagemeta_lightbox_video'][0]; }
		if ( isset($custom['pagemeta_customthumbnail'][0]) ) { $thumbnail=$custom['pagemeta_customthumbnail'][0]; }
		if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { $description=$custom['pagemeta_thumbnail_desc'][0]; }
		if ( isset($custom['pagemeta_customlink'][0]) ) { $customlink_URL=$custom['pagemeta_customlink'][0]; }
		if ( isset($custom['pagemeta_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom['pagemeta_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$add_space_class = '';
		if ( $gutter!='nospace') {
			if ($title=='false' && $desc=='false') {
				$add_space_class = 'gridblock-cell-bottom-space';
			}
		}

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfolio_total_count++;

		$gridblock_ajax_class='';
		if ($type=='ajax') {
			$gridblock_ajax_class="gridblock-ajax ";
		}

		// Generate main DIV tag with portfolio information with filterable tags
		$portfoliogrid .= '<div class="gridblock-element  '.$animation_class.' isotope-displayed gridblock-element-id-'.get_the_ID().' gridblock-element-order-'.$portfolio_total_count.' '.$add_space_class.' gridblock-filterable ';
		if ( is_array($portfolio_cats) ) {
			foreach ($portfolio_cats as $taxonomy) { 
				$portfoliogrid .=  'filter-' . $taxonomy->slug . ' ';
				if ($pagination=='true') {
					if (in_array($taxonomy->slug, $portfoliofilters)) {
					} else {
						$portfoliofilters[] = $taxonomy->slug;
					}
				}
			}
		}
		$idCount++;
		$portfoliogrid .= '" data-portfolio="portfolio-'. get_the_ID() .'" data-id="id-'. $idCount .'">';
			$portfoliogrid .= '<div class="'.$gridblock_ajax_class.'gridblock-grid-element gridblock-element-inner" data-portfolioid="'.get_the_id().'">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';

				if ( post_password_required() ) {
					$the_only_link = true;
					$the_protected_link = true;
					$portfolio_link_type = "Protected";
					$protected=" gridblock-protected"; $iconclass="";
				}


		//if Password Required

			//Make sure it's not a slideshow
		if ($type !="ajax") {
				//Switch check for Linked Type
			//Switch check for Linked Type
			//
				if ($portfolio_link_type=="Lightbox_DirectURL") {
					$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
				}

				if ( post_password_required() ) {
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i>';					
				} else {

					if ($portfolio_link_type=="Lightbox_DirectURL") {
						$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i></span>';
						$portfoliogrid .= '</a>';
					}

					
					switch ($portfolio_link_type) {
						case 'DirectURL':
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i>';
							break;

						case 'Customlink':
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.$customlink_URL.'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('link').'"></i>';
							break;

						case 'Lightbox_DirectURL':
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="column-gridblock-icon column-gridblock-lightbox lightbox-video",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="feather-icon-play"></i>';
							} else {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=imaginem_codepack_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
									$class="column-gridblock-icon column-gridblock-lightbox lightbox-image",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i>';							
							}
							break;
						case 'Lightbox':
							$the_only_link = true;
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="gridblock-sole-link column-gridblock-lightbox lightbox-video",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="feather-icon-play"></i>';
							} else {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=imaginem_codepack_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
									$class="gridblock-sole-link column-gridblock-lightbox lightbox-image",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i>';							
							}
							break;
						default:
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('albums').'"></i>';
							break;
					}

					if ($portfolio_link_type != "Lightbox_DirectURL") {
						$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
					}
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						if ($the_only_link) {
							$portfoliogrid .= '<span class="column-gridblock-icon">';
						}
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
						if ($the_only_link) {
							$portfoliogrid .= '</span>';
						}
					}
					if ($portfolio_link_type != "Lightbox_DirectURL") {
						$portfoliogrid .= '</div>';
					}
					$portfoliogrid .= '</a>';
				}
				if ($portfolio_link_type == "Lightbox_DirectURL") {
					$portfoliogrid .= '</div>';
				}

				if ( post_password_required() ) {
					$portfoliogrid .= '</a>';
				}
				//$portfoliogrid .= '</span>';
				// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
				// Custom Thumbnail
		// If AJAX
		} else {
			$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
			$portfoliogrid .= '<span class="column-gridblock-icon">';
			$icon_class='<i class="' . imaginem_codepack_get_portfolio_icon('ajax') . '"></i>';
			$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
			$portfoliogrid .= '</span>';
			$portfoliogrid .= '</div>';
		}
				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = '';
					$seperator = ',';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					$portfoliogrid .= '</span>';
				}
		$portfoliogrid .= '</div>';

		$fade_in_class ="";
		if ( post_password_required() ) {

			$portfoliogrid .= '<div class="gridblock-protected">';
			$portfoliogrid .= '<span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('locked').'"></i></span>';
			if ( $format == "portrait" ) {
				$protected_placeholder = '/images/blank-grid-portrait.png';
			} else {
				$protected_placeholder = '/images/blank-grid.png';
			}
			$portfoliogrid .= '<img class="'.$fade_in_class.'displayed-image" src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
			$portfoliogrid .= '</div>';

		} else {
			if ($thumbnail<>"") {
				$portfoliogrid .= '<img src="'.$thumbnail.'" class="'.$fade_in_class.'displayed-image" alt="thumbnail" />';
			} else {
				// Slideshow then generate slideshow shortcode
				$portfoliogrid .= imaginem_codepack_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$imagetype=$portfolioImage_type,
					$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
					$class= $fade_in_class."displayed-image"
				);

			}
		}
	$portfoliogrid .='</div>';
		if ($title=='true' || $desc=='true') {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($category_display=='true') {
					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = '';
					$seperator = ' , ';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}

					$portfoliogrid .= '<div class="worktype-categories">'.$current_worktype.'</div>';
				}
				if ($title=='true') {
					if ($type != "ajax") {
						$portfoliogrid .='<h4><a href="'.$hreflink.'">'. get_the_title() .'</a></h4>';
					} else {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .= get_the_title();
						$portfoliogrid .= '</h4>';
					}
				}
				if ($desc=='true') $portfoliogrid .= '<p class="entry-content work-description">'.$description.'</p>';
			$portfoliogrid .='</div>';
		}


	$portfoliogrid .='</div>';

	//if ($portfolio_count==$columns)  $portfoliogrid .='</div>';

	endwhile; endif;
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '</div>';
	// }
	$portfoliogrid .='</div>';

	if ($pagination=='true') { 
		$portfoliogrid .= '<div class="clearfix">';
		$portfoliogrid .= imaginem_codepack_pagination();
		$portfoliogrid .= '</div>';
	}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("clientgrid", "mClientGrids");
/**
 * Client Grid
 */
if ( !function_exists( 'mProofingArchive' ) ) {
	function mProofingArchive($atts, $content = null) {
		extract(shortcode_atts(array(
			"client_id" => '',
			"pageid" => '',
			"format" => '',
			"columns" => '4',
			"animated" => 'true',
			"limit" => '-1',
			"filter_subcats" => "true",
			"category_display" => "true",
			"gutter" => 'spaced',
			"boxtitle" => 'false',
			"title" => 'true',
			"desc" => 'true',
			"worktype_slugs" => '',
			"pagination" => 'false',
			"type" => 'filter'
		), $atts));

    if ($animated == "true") {
        $animation_class = ' animation-standby-portfolio animated thumbnailFadeInUpSlow';
    }

	$portfoliogrid ='';
	$subcat_filter_portfoliogrid = '';

	// Set a default
	$column_type="four";
	$portfolioImage_type="kreativa-gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="kreativa-gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="kreativa-gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = "gridblock-masonary ";
		if ($columns==4) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="kreativa-gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="kreativa-gridblock-full";
			}
	}

	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.get_template_directory_uri().$protected_placeholder.'" alt="preloading" /></div>';
	$thumbnail_gutter_class =  'portfolio-gutter-'.$gutter.' ';
	if ($gutter=="nospace") {
		$thumbnail_gutter_class .=  'thumnails-gutter-active ';
	}
	if ($title<>"true" && $desc<>"true") {
		$thumbnail_gutter_class .=  'no-title-no-desc ';
	}
	$boxtitle_class='';
	if ($boxtitle=="true") {
		$boxtitle_class=" boxtitle-active";
	}
	$flag_new_row=true;

	$portfoliogrid .= '<div class="gridblock-columns-wrap clearfix">';
	$portfoliogrid .= '<div id="gridblock-container" class="'.$thumbnail_gutter_class.$gridblock_is_masonary.$boxtitle_class.' gridblock-'.$column_type.' clearfix" data-columns="'.$columns.'">';

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	$count=0;
	$terms=array();
	$work_slug_array=array();

	$current_page_id = get_the_id();
        //echo $worktype_slugs;
    if ($worktype_slugs != "") {
        $type_explode = explode(",", $worktype_slugs);
        foreach ($type_explode as $work_slug) {
            $terms[] = $work_slug;
        }
        query_posts(array(
            'post_type' => 'mtheme_proofing',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'paged' => $paged,
            'posts_per_page' => $limit,
            'tax_query' => array(
                array(
                    'taxonomy' => 'proofingsection',
                    'field' => 'slug',
                    'terms' => $terms,
                    'operator' => 'IN'
                )
            )
        ));
    } else {
		query_posts(
			array(
				'post_type' => 'mtheme_proofing',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'paged' => $paged,
				'posts_per_page' => $limit
	        )
	    );
    }

	$idCount=1;
	$portfolio_count=0;
	$portfolio_total_count=0;
	$portfoliofilters = array();

	if (have_posts()) : while (have_posts()) : the_post();
			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'proofingsection' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$description="";
		$portfolio_link_type="";
		$portfolio_thumb_header="Image";
		$the_only_link = false;
		$the_protected_link = false;

		if ( isset($custom['pagemeta_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom['pagemeta_thumbnail_linktype'][0]; }
		if ( isset($custom['pagemeta_lightbox_video'][0]) ) { $lightboxvideo=$custom['pagemeta_lightbox_video'][0]; }
		if ( isset($custom['pagemeta_customthumbnail'][0]) ) { $thumbnail=$custom['pagemeta_customthumbnail'][0]; }
		if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { $description=$custom['pagemeta_thumbnail_desc'][0]; }
		if ( isset($custom['pagemeta_customlink'][0]) ) { $customlink_URL=$custom['pagemeta_customlink'][0]; }
		if ( isset($custom['pagemeta_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom['pagemeta_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$add_space_class = '';
		if ( $gutter!='nospace') {
			if ($title=='false' && $desc=='false') {
				$add_space_class = 'gridblock-cell-bottom-space';
			}
		}

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfolio_total_count++;

		$gridblock_ajax_class='';
		if ($type=='ajax') {
			$gridblock_ajax_class="gridblock-ajax ";
		}

		// Generate main DIV tag with portfolio information with filterable tags
		$portfoliogrid .= '<div class="gridblock-element  '.$animation_class.' isotope-displayed gridblock-element-id-'.get_the_ID().' gridblock-element-order-'.$portfolio_total_count.' '.$add_space_class.' gridblock-filterable ';
		if ( is_array($portfolio_cats) ) {
			foreach ($portfolio_cats as $taxonomy) { 
				$portfoliogrid .=  'filter-' . $taxonomy->slug . ' ';
				if ($pagination=='true') {
					if (in_array($taxonomy->slug, $portfoliofilters)) {
					} else {
						$portfoliofilters[] = $taxonomy->slug;
					}
				}
			}
		}
		$idCount++;
		$portfoliogrid .= '" data-portfolio="portfolio-'. get_the_ID() .'" data-id="id-'. $idCount .'">';
			$portfoliogrid .= '<div class="'.$gridblock_ajax_class.'gridblock-grid-element gridblock-element-inner" data-portfolioid="'.get_the_id().'">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';

				if ( post_password_required() ) {
					$the_only_link = true;
					$the_protected_link = true;
					$portfolio_link_type = "Protected";
					$protected=" gridblock-protected"; $iconclass="";
				}


		//if Password Required

			//Make sure it's not a slideshow
		if ($type !="ajax") {
				//Switch check for Linked Type
			//Switch check for Linked Type
			//
				if ($portfolio_link_type=="Lightbox_DirectURL") {
					$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
				}

				if ( post_password_required() ) {
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i>';					
				} else {

					if ($portfolio_link_type=="Lightbox_DirectURL") {
						$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i></span>';
						$portfoliogrid .= '</a>';
					}

					
					switch ($portfolio_link_type) {
						case 'DirectURL':
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('directlink').'"></i>';
							break;

						case 'Customlink':
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.$customlink_URL.'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('link').'"></i>';
							break;

						case 'Lightbox_DirectURL':
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="column-gridblock-icon column-gridblock-lightbox lightbox-video",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="feather-icon-play"></i>';
							} else {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=imaginem_codepack_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
									$class="column-gridblock-icon column-gridblock-lightbox lightbox-image",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i>';							
							}
							break;
						case 'Lightbox':
							$the_only_link = true;
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="gridblock-sole-link column-gridblock-lightbox lightbox-video",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="feather-icon-play"></i>';
							} else {
								$portfoliogrid .=
								imaginem_codepack_activate_lightbox (
									$lightbox_type="default",
									$ID=get_the_id(),
									$predefined=imaginem_codepack_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
									$class="gridblock-sole-link column-gridblock-lightbox lightbox-image",
									$set="portfolio-grid",
									$data_name="default",
                                    $external_thumbnail_id = get_post_thumbnail_id( get_the_id() ),
                                    $imageDataID=get_post_thumbnail_id( get_the_id() )
								);
								$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('lightbox').'"></i>';							
							}
							break;
						default:
							$the_only_link = true;
							$portfoliogrid .= '<a class="gridblock-sole-link" href="'.get_permalink() .'">';
							$icon_class='<i class="'.imaginem_codepack_get_portfolio_icon('albums').'"></i>';
							break;
					}

					if ($portfolio_link_type != "Lightbox_DirectURL") {
						$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
					}
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						if ($the_only_link) {
							$portfoliogrid .= '<span class="column-gridblock-icon">';
						}
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
						if ($the_only_link) {
							$portfoliogrid .= '</span>';
						}
					}
					if ($portfolio_link_type != "Lightbox_DirectURL") {
						$portfoliogrid .= '</div>';
					}
					$portfoliogrid .= '</a>';
				}
				if ($portfolio_link_type == "Lightbox_DirectURL") {
					$portfoliogrid .= '</div>';
				}

				if ( post_password_required() ) {
					$portfoliogrid .= '</a>';
				}
				//$portfoliogrid .= '</span>';
				// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
				// Custom Thumbnail
		// If AJAX
		} else {
			$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';
			$portfoliogrid .= '<span class="column-gridblock-icon">';
			$icon_class='<i class="' . imaginem_codepack_get_portfolio_icon('ajax') . '"></i>';
			$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
			$portfoliogrid .= '</span>';
			$portfoliogrid .= '</div>';
		}
				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = '';
					$seperator = ',';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					$portfoliogrid .= '</span>';
				}
		$portfoliogrid .= '</div>';

		$fade_in_class ="";
		if ( post_password_required() ) {

			$portfoliogrid .= '<div class="gridblock-protected">';
			$portfoliogrid .= '<span class="hover-icon-effect"><i class="'.imaginem_codepack_get_portfolio_icon('locked').'"></i></span>';
			if ( $format == "portrait" ) {
				$protected_placeholder = '/images/blank-grid-portrait.png';
			} else {
				$protected_placeholder = '/images/blank-grid.png';
			}
			$portfoliogrid .= '<img class="'.$fade_in_class.'displayed-image" src="'.get_template_directory_uri().$protected_placeholder.'" alt="blank" />';
			$portfoliogrid .= '</div>';

		} else {
			if ($thumbnail<>"") {
				$portfoliogrid .= '<img src="'.$thumbnail.'" class="'.$fade_in_class.'displayed-image" alt="thumbnail" />';
			} else {
				// Slideshow then generate slideshow shortcode
				$portfoliogrid .= imaginem_codepack_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$imagetype=$portfolioImage_type,
					$imagetitle=imaginem_codepack_image_title( get_the_ID() ),
					$class= $fade_in_class."displayed-image"
				);

			}
		}
	$portfoliogrid .='</div>';
		if ($title=='true' || $desc=='true') {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($category_display=='true') {
					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = '';
					$seperator = ' , ';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}

					$portfoliogrid .= '<div class="worktype-categories">'.$current_worktype.'</div>';
				}
				if ($title=='true') {
					if ($type != "ajax") {
						$portfoliogrid .='<h4><a href="'.$hreflink.'">'. get_the_title() .'</a></h4>';
					} else {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .= get_the_title();
						$portfoliogrid .= '</h4>';
					}
				}
				if ($desc=='true') $portfoliogrid .= '<p class="entry-content work-description">'.$description.'</p>';
			$portfoliogrid .='</div>';
		}


	$portfoliogrid .='</div>';

	//if ($portfolio_count==$columns)  $portfoliogrid .='</div>';

	endwhile; endif;
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '</div>';
	// }
	$portfoliogrid .='</div>';
	$portfoliogrid .='</div>';

	if ($pagination=='true') { 
		$portfoliogrid .= '<div class="clearfix">';
		$portfoliogrid .= imaginem_codepack_pagination();
		$portfoliogrid .= '</div>';
	}

		wp_reset_query();


        if ($type == "filter" && $worktype_slugs == "") {

        	$hide_filter  = '';
        	$filter_seperator  = '';
            
            $filter_portfoliogrid = "";
            
            $countquery = array(
                'post_type' => 'mtheme_proofing',
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
            
            $filter_portfoliogrid .= '<div class="gridblock-filter-select-wrap">';
            
            $filter_portfoliogrid .= '<div id="gridblock-filters">';
            $filter_portfoliogrid .= '<ul class="gridblock-filter-categories">';
            
            $filter_portfoliogrid .= '<li class="filter-all-control">';
            $filter_portfoliogrid .= '<a data-filter="*" data-title="All" href="#">';
            $filter_portfoliogrid .= '<span class="filter-seperator filter-seperator-all"></span>All';
            $filter_portfoliogrid .= '</a>';
            $filter_portfoliogrid .= '</li>';
            
            //$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
            if ($worktype_slugs != '')
                $all_works = explode(",", $worktype_slugs);
            if ($filter_subcats == "true") {
                $categories = get_categories('orderby=slug&parent=0&taxonomy=proofingsection&title_li=');
            } else {
                $categories = get_categories('orderby=slug&taxonomy=proofingsection&title_li=');
            }
            foreach ($categories as $category) {
                
                $taxonomy = "proofingsection";
                
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
                        $portfolio_subcategories = get_categories('orderby=slug&taxonomy=proofingsection&child_of=' . $category->term_id . '&title_li=');
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
		return $portfoliogrid;
	}
}
add_shortcode("proofingarchive", "mProofingArchive");
?>