<?php
get_header();
?>
<?php
$portfolio_style= get_post_meta($post->ID, 'pagemeta_portfolio_style', true);
$portfolio_category= get_post_meta($post->ID, 'pagemeta_portfolio_category', true);
$portfolio_link= get_post_meta($post->ID, 'pagemeta_portfolio_link', true);

$portfolio_layout=kreativa_get_option_data('photostory_achivelisting');

$portfolio_perpage="6";
$count=0;
$columns=$portfolio_layout;
if ( $columns<3 ) {
	$columns=3;
}

$portfolio_cat= get_term_by ( 'name', $portfolio_category,'fullscreengallery' );
if (isset($portfolio_cat -> slug)) { $portfolio_cat_slug=$portfolio_cat -> slug; $portfolio_category=$portfolio_cat_slug; }
if (isset($portfolio_cat -> term_id)) $portfolio_cat_ID=$portfolio_cat -> term_id;

// Get which term is being querries and do shortcode with $term->slug
$term = get_queried_object();
if (!isSet($term->slug) ) {
	$worktype='';
} else {
	$worktype = $term->slug;
}
?>
<div class="entry-content fullwidth-column clearfix">
<?php
$format=kreativa_get_option_data('gallery_archive_format');
if ( $format<>"landscape" && $format<>"square" && $format<>"portrait" && $format<>"masonary" ) {
	$format="landscape";
}
echo do_shortcode('[gallerygrid grid_post_type="mtheme_featured" grid_taxonomy="fullscreengallery" displaycategory="false" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'"]');
?>
</div>
<?php get_footer(); ?>