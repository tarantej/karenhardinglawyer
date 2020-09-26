<?php
get_header();
?>
<div class="entry-content fullwidth-column clearfix">
<?php
$term = get_queried_object();
if (!isSet($term->slug) ) {
	$worktype='';
} else {
	$worktype = $term->slug;
}
$format=kreativa_get_option_data('proofing_archive_format');
$columns=kreativa_get_option_data('proofing_achivelisting');
echo do_shortcode('[proofingarchive worktype_slugs="'.$worktype.'" format="'.$format.'" boxtitle="true" title="false" desc="false" columns="'.$columns.'" padeid=""]');?>
</div>
<?php get_footer(); ?>