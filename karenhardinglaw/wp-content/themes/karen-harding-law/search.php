<?php
/*
*  Search Page
*/
?>
 
<?php get_header(); ?>
<?php
$mtheme_pagelayout_type="float-left two-column";
if ( have_posts() ) : ?>

	<div class="contents-wrap <?php echo esc_attr($mtheme_pagelayout_type); ?>">

		<?php
			get_template_part( 'loop', 'search' );
		?>
	</div>

	<?php get_sidebar(); ?>
	<?php else : ?>
	<div class="page-contents-wrap">
		<div class="entry-wrapper lower-padding">
		<div class="entry-spaced-wrapper">
			<div class="entry-content mtheme-search-no-results">
				<h4><?php esc_html_e( 'Nothing Found', 'kreativa' ); ?></h4>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with different keywords.', 'kreativa' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div>
		</div>
	</div>

<?php endif;
get_footer();
?>