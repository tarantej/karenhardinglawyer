<?php get_header(); ?>
<div id="vertical-center-wrap">
    <div class="vertical-center-outer">
        <div class="vertical-center-inner">
	<div class="entry-page-wrapper entry-content clearfix">
		<div class="site-in-maintenance">
			<?php
			$maintenance_text = kreativa_get_option_data('maintenance_text');
			?>
			<div class="site-maintenance-text"><?php echo wp_kses_post($maintenance_text); ?></div>
		</div>
	</div><!-- .entry-content -->
        </div>
    </div>
</div>
<?php get_footer(); ?>