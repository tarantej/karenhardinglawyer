<?php
get_header();
?>
<?php
$portfolio_perpage="6";
$count=0;
$columns=3;

$term = get_queried_object();
if (!isSet($term->slug) ) {
	$worktype='';
} else {
	$worktype = $term->slug;
}
?>
<div class="entry-content fullwidth-column clearfix">
<?php
$format=kreativa_get_option_data('photostory_archive_format');
if ( $format<>"landscape" && $format<>"square" && $format<>"portrait" && $format<>"masonary" ) {
	$format="landscape";
}
echo do_shortcode('[gallerygrid grid_post_type="mtheme_featured" grid_taxonomy="fullscreengallery" displaycategory="false" desc="true" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'"]');
?>
</div>
<?php get_footer(); ?>