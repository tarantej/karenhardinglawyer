<?php
get_header();
?>
<div class="entry-content fullwidth-column clearfix">
<?php
$format=kreativa_get_option_data('proofing_archive_format');
$columns=kreativa_get_option_data('proofing_achivelisting');
echo do_shortcode('[proofingarchive format="'.$format.'" boxtitle="true" title="false" desc="false" columns="'.$columns.'" padeid=""]');?>
</div>
<?php get_footer(); ?>