<?php
/*
404 Page
*/
?>
<?php get_header(); ?>

<div id="vertical-center-wrap">
    <div class="vertical-center-outer">
        <div class="vertical-center-inner">
	<div class="entry-page-wrapper entry-content clearfix">
		<div class="mtheme-404-wrap">
			<div class="mtheme-404-icon">
				<i class="et-icon-caution"></i>
			</div>
			<?php
			$error_msg = kreativa_get_option_data('404_title');
			if ($error_msg=="") {
				$error_msg = esc_html__(  '404 Page not Found!', 'kreativa' );
			}
			?>
			<div class="mtheme-404-error-message1"><?php echo esc_attr($error_msg); ?></div>
			<h4><?php esc_html_e( 'Would you like to search for the page', 'kreativa' ); ?></h4>
			<?php get_search_form(); ?>
		</div>
	</div><!-- .entry-content -->
        </div>
    </div>
</div>
<?php get_footer(); ?>