<?php
function imaginem_codepack_display_elementloader($intensity="default") {
	return '<svg class="materialcircular materialcircular-'.$intensity.'" height="50" width="50">
  <circle class="materialpath" cx="25" cy="25" r="20" fill="none" stroke-width="6" stroke-miterlimit="10" />
</svg>';
}
function imaginem_codepack_trim_sentence($desc="",$charlength=20) {
	$excerpt = $desc;

	$the_text="";

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$the_text = mb_substr( $subex, 0, $excut );
		} else {
			$the_text = $subex;
		}
		$the_text .= '[...]';
	} else {
		$the_text = $excerpt;
	}
	return $the_text;
}
function imaginem_codepack_get_portfolio_icon( $postformat = "image" ) {
	switch ($postformat) {
		case 'directlink':
			$postformat_icon = "ion-ios-plus-empty";
			break;
		case 'lightbox':
			$postformat_icon = "ion-ios-search";
			break;
		case 'link':
			$postformat_icon = "ion-ios-arrow-thin-up";
			break;
		case 'play':
			$postformat_icon = "ion-ios-play-outline";
			break;
		case 'cross':
			$postformat_icon = "ion-ios-close-empty";
			break;
		case 'proofing-check':
			$postformat_icon = "ion-ios-checkmark-outline";
			break;
		case 'proofing-cross':
			$postformat_icon = "ion-ios-close-outline";
			break;
		case 'check':
			$postformat_icon = "ion-ios-checkmark-outline";
			break;
		case 'download':
			$postformat_icon = "ion-ios-download-outline";
			break;
		case 'purchase':
			$postformat_icon = "ion-ios-cart-outline";
			break;
		case 'albums':
			$postformat_icon = "ion-ios-albums-outline";
			break;
		case 'selected':
			$postformat_icon = "ion-ios-heart";
			break;
		case 'locked':
			$postformat_icon = "ion-ios-locked-outline";
			break;
		case 'ajax':
			$postformat_icon = "ion-ios-eye-outline";
			break;
		default:
			$postformat_icon = "ion-ios-plus-empty";
			break;
	}

	return $postformat_icon;
}
function imaginem_codepack_get_postformat_icon( $postformat = "standard" ) {
	switch ($postformat) {
		case 'video':
			$postformat_icon = "ion-ios-film-outline";
			break;
		case 'audio':
			$postformat_icon = "ion-ios-musical-notes";
			break;
		case 'gallery':
			$postformat_icon = "ion-ios-albums-outline";
			break;
		case 'quote':
			$postformat_icon = "ion-ios-chatbubble-outline";
			break;
		case 'link':
			$postformat_icon = "ion-ios-redo-outline";
			break;
		case 'aside':
			$postformat_icon = "ion-ios-redo-outline";
			break;
		case 'image':
			$postformat_icon = "ion-ios-camera-outline";
			break;
		default:
			$postformat_icon = "ion-ios-compose-outline";
			break;
	}

	return $postformat_icon;
}
// Get Attached images applied with custom script
function imaginem_codepack_get_pagemeta_infobox_set( $page_id ) {
	$filter_image_ids = false;
	$the_image_ids = get_post_meta( $page_id , 'pagemeta_infoboxes');
	if ($the_image_ids) {
		$filter_image_ids = explode(',', $the_image_ids[0]);
		return $filter_image_ids;
	}
}
function imaginem_codepack_country_list($output_type="select",$selected=""){
	$countries = array
	(
		'none' => "Choose Country",
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
	$country_list = false;
	if ($output_type=="select") {
		$country_list="";
		foreach ($countries as $key => $option) {
		    if ($selected==$key) {
		    	$country_selected='selected="selected"';
		    } else {
		    	$country_selected="";
		    }
			$country_list .= '<option value="'. esc_attr($key) .'" '.$country_selected.'>'. esc_attr($option) . '</option>';
		}
	}
	if ($output_type=="display") {
		if (array_key_exists($selected,$countries)) {
			$country_list = $countries[$selected];
		}
	}
	return $country_list;
}
function imaginem_codepack_is_hex_color($color) {
	if(preg_match('/^#[a-f0-9]{6}$/i', $color)) {
		return true;
	}
	return false;
}
/**
 * [mtheme_shortcodefunction_hex_to_rgb description]
 * @param  [type] $color [description]
 * @return [type]        [description]
 */
function mtheme_shortcodefunction_hex_to_rgb($color)
{
	if (substr($color, 0, 1) === '#') {
		$color = substr($color, 1);
	}

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}
/**
 * [kreativa_excerpt_limit description]
 * @param  [type] $limit [description]
 * @return [type]        [description]
 */
function imaginem_codepack_excerpt_limit($limit) {
	  if (!is_numeric($limit)) {
	  	$limit = 15;
	  }
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
 }
/**
 * [imaginem_codepack_activate_lightbox Activate a Lightbox]
 * @param  [type] $lightbox_type [lightbox type]
 * @param  [type] $ID            [image ID]
 * @param  [type] $predefined    [predefined link of lightbox image]
 * @param  [type] $mediatype     [image or video]
 * @param  [type] $title         [the title]
 * @param  [type] $class         [class to add]
 * @param  [type] $navigation    [more than one image]
 * @return [type]                [description]
 */
if ( !function_exists( 'imaginem_codepack_activate_lightbox' ) ) {
	function imaginem_codepack_activate_lightbox ($lightbox_type="default",$ID="",$predefined=false,$mediatype="image",$title="",$class="",$set=false,$data_name="default", $external_thumbnail_id =false, $imageDataID = false ) {

		$link = '';
		if ($data_name=="default") {
			$data_name = "data-src";
		}
		if ($ID=="") {
			$ID = get_the_id();
		}
		$gallery='';
		if ($set) {
			// for gallery
		}
		if ($predefined) {
			$link = $predefined;
		}
		if ($external_thumbnail_id) {
			$imagearray = wp_get_attachment_image_src($external_thumbnail_id, 'kreativa-gridblock-tiny', false);
            $thumbnail_link   = $imagearray[0];
		} else {
			if ($predefined) {
				$thumbnail_link = $predefined;
			}
		}

        $featured_image_id = $imageDataID;
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

		$purchase_tag= '';
		$purchase_link_present= '';
		if ($purchase_link) {
			$purchase_tag = '<span class="lightbox-purchase"><a href="'.esc_url($purchase_link).'">Purchase</a></span>';
			$purchase_link_present = "has-purchase-link";
		}

		$desc = '';
		if ( $featuredimg_desc<>"" || $purchase_tag<>"" ) {
			$desc =  '<div class="lightbox-text entry-content">'.$featuredimg_desc.$purchase_tag.'</div>';
		}

		$html_subtext = '<div class="lightbox-text-wrap '.$purchase_link_present.'"><h4 class="lightbox-text">'.$featuredimg_title.'</h4>'.$desc.'</div>';

		$output = false;
		if ( isSet($link) && $link<>"" ) {
			$output='<a data-exthumbimage="'.esc_url( $thumbnail_link ).'" '.$gallery.'class="lightbox-active '.$class.'" data-sub-html="'.esc_attr($html_subtext).'" href="'.esc_url( $link ).'" '.$data_name.'="'.$link.'">';
		}
		return $output;
	}
}

/*-------------------------------------------------------------------------*/
/* Show featured image title */
/*-------------------------------------------------------------------------*/
/**
 * [imaginem_codepack_image_title description]
 * @param  [type] $ID [description]
 * @return [type]     [description]
 */
function imaginem_codepack_image_title ($ID) {
	$img_title='';
	$image_id = get_post_thumbnail_id($ID);
	$img_obj = get_post($image_id);
	if (isSet($img_obj)){
		$img_title = $img_obj->post_title;
	}
	return $img_title;
}
/*-------------------------------------------------------------------------*/
/* Show featured image link */
/*-------------------------------------------------------------------------*/
/**
 * [imaginem_codepack_featured_image_link description]
 * @param  [type] $ID [description]
 * @return [type]     [description]
 */
function imaginem_codepack_featured_image_link ($ID) {
	$image_id = get_post_thumbnail_id($ID, 'full'); 
	$image_url = wp_get_attachment_image_src($image_id,'full');  
	$image_url = $image_url[0];
	return $image_url;
}
// Get Attached images applied with custom script
/**
 * [imaginem_codepack_get_custom_attachments description]
 * @param  [type] $page_id [description]
 * @return [type]          [description]
 */
function imaginem_codepack_get_custom_attachments( $page_id ) {
	$filter_image_ids = false;
	$the_image_ids = get_post_meta( $page_id , '_mtheme_image_ids');
	if ($the_image_ids) {
		$filter_image_ids = explode(',', $the_image_ids[0]);
		return $filter_image_ids;
	}
}
// Displays alt text based on ID
function imaginem_codepack_get_alt_text($attatchmentID) {
	$alt = get_post_meta($attatchmentID, '_wp_attachment_image_alt', true);
	return $alt;
}
function imaginem_codepack_display_post_image ($ID,$have_image_url,$link,$type,$title,$class,$lazyload=false) {

	if ($type=="") $type="fullsize";
	$output="";
	
	$image_id = get_post_thumbnail_id(($ID), $type); 
	$image_url = wp_get_attachment_image_src($image_id,$type);  
	$image_url = $image_url[0];

	$img_obj = get_post($image_id);
	$img_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	$permalink = get_permalink( $ID );
	
	if ($link==true) {
		$output = '<a href="' . esc_url( $permalink ) . '">';
	}
	
	$data_src = '';
	if ($lazyload=="true") {
		$data_src = "data-";
		$class = $class . ' lazyload';
	}
	if ($have_image_url) {
		$img_alt = imaginem_codepack_get_alt_text($ID);
		$output .= '<img '.$data_src.'src="'. esc_url( $have_image_url ) .'" alt="'. esc_attr( $img_alt ) .'" class="'. $class .'"/>';
	} else {
		if (isSet($image_url) && $image_url<>"") {
			if ($class) {
				$output .= '<img '.$data_src.'src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $img_alt ) .'" class="'. $class .'"/>';
			} else {
				$output .= '<img '.$data_src.'src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $img_alt ) .'" />';
			}
		}
	}
	
	if ($link==true) {
		$output .= '</a>';
	}
	
	return $output;
}
function imaginem_codepack_display_like_link($post_id)
{
	$themename = MTHEME;

	$vote_count = get_post_meta($post_id, "votes_count", true);
	
	if (! $vote_count) $vote_count="0";

	$output = '<div class="mtheme-post-like-wrap">';
	$output .= '<div class="mtheme-post-like">';
	if(imaginem_ingencreative_hasAlreadyVoted($post_id))
		$output .= ' <span class="mtheme-like like-vote-icon like-alreadyvoted"><i class="fa fa-thumbs-o-up"></i></span>';
	else
		$output .= '<a class="vote-ready" href="#" data-post_id="'.$post_id.'">
					<span class="mtheme-like like-vote-icon like-notvoted"><i class="fa fa-thumbs-o-up"></i></span>
				</a>';
	$output .= '<div class="post-link-count-wrap" data-count_id="'.$post_id.'"><span class="post-like-count">' . $vote_count . '</span> found this helpful</div>';
	$output .= '</div>';
	$output .= '</div>';
	
	return $output;
}
// Custom Pagination codes
function imaginem_codepack_pagination($pages = '', $range = 4)
{ 
	$pagination='';
     $showitems = ($range * 2)+1; 
 
    global $paged;
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         $pagination .= '<div class="pagination-navigation">';
         $pagination .=  "<div class=\"pagination\"><span class=\"pagination-info\">". __("Page ","mthemelocal") . $paged. __(" of ","mthemelocal") .$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) $pagination .=  "<a class='pagination-first' href='". esc_url( get_pagenum_link(1) )."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) $pagination .=  "<a class='pagination-previous' href='".esc_url( get_pagenum_link($paged - 1) )."'>&lsaquo;</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 $pagination .=  ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".esc_url( get_pagenum_link($i) )."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) $pagination .=  "<a href=\"".esc_url( get_pagenum_link($paged + 1) )."\">&rsaquo;</a>"; 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $pagination .=  "<a href='".esc_url( get_pagenum_link($pages) )."'>&raquo;</a>";
         $pagination .=  "</div>";
         $pagination .=  "</div>";
     }
     return $pagination;
}
function imaginem_codepack_get_option_data( $name, $default = false ) {
	
	$opt_value=get_option( 'mtheme_' .  $name );
	if ( isset( $opt_value ) ) {
		return $opt_value;
	}
	return $default;
}
?>