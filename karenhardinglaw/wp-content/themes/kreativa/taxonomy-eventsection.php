<?php
get_header();
?>
<?php
$event_achivelisting=kreativa_get_option_data('event_achivelisting');

$portfolio_perpage="6";
$count=0;
$columns=$event_achivelisting;

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
$format=kreativa_get_option_data('portfolio_archive_format');
echo do_shortcode('[gridcreate grid_post_type="mtheme_events" grid_tax_type="eventsection" boxtitle="false" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'" title="true" desc="true"]');
?>
</div>
<?php get_footer(); ?>