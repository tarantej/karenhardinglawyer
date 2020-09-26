<?php
/*
*  Page
*/
?>
<?php get_header(); ?>
<?php
$events_page_id = $post->ID;
$custom = get_post_custom(get_the_id());
if (isset($custom['pagemeta_event_notice'][0])) $event_notice=$custom['pagemeta_event_notice'][0];

	if ( post_password_required() ) {
		echo '<div class="entry-content" id="password-protected">';
		echo '<span class="password-protected-icon"><i class="ion-ios-locked-outline"></i></span>';
		echo get_the_password_form();
		do_action('kreativa_demo_password');
		echo '</div>';
		do_action('kreativa_display_portfolio_single_navigation');
	} else {

		$postponed_msg = kreativa_get_option_data('events_postponed_msg');
		$cancelled_msg = kreativa_get_option_data('events_cancelled_msg');
		switch ($event_notice) {
			case 'postponed':
				echo '<div class="entry-content events-notice is-animated animated fadeIn">';
				echo do_shortcode('[alert type="blue" icon="mfont et-icon-clock"]'. $postponed_msg .'[/alert]');
				echo '</div>';
				break;
		case 'cancelled':
				echo '<div class="entry-content events-notice is-animated animated fadeIn">';
				echo do_shortcode('[alert type="red" icon="mfont et-icon-caution"]'. $cancelled_msg .'[/alert]');
				echo '</div>';
				break;
			default:
				# code...
				break;
		}

	$filter_image_ids = kreativa_get_custom_attachments ( get_the_id() );
	$mtheme_pagestyle= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
	$floatside="float-left";
	if ($mtheme_pagestyle=="nosidebar") { $floatside=""; }
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
		$mtheme_pagestyle="rightsidebar";
		$floatside="float-left";
	}
	$image_size_type = "kreativa-gridblock-full-medium";
	if ( $mtheme_pagestyle=="fullwidth") {
		$floatside='';
		$image_size_type = "kreativa-gridblock-full";
		$mtheme_pagestyle='nosidebar';
	}
	?>
	<div class="page-contents-wrap <?php echo esc_attr($floatside); ?> <?php if ($mtheme_pagestyle != "nosidebar") { echo 'two-column'; } ?>">
	<?php
	$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
	$page_builder_mode = false;
	if (isSet($isactive) && $isactive==1) {
		$page_builder_mode = true;
	}
	if ( !$page_builder_mode ) {
		echo '<div class="events-main-wrap">';
		if ( has_post_thumbnail() ) {
			echo '<div class="events-image-wrap">';
			echo kreativa_display_post_image (
				$post->ID,
				$have_image_url=false,
				$link=false,
				$type=$image_size_type,
				$post->post_title,
				$class="portfolio-single-image" 
			);
			echo '</div>';
		}
		echo '</div>';
	}
	if ( $page_builder_mode ) {
		echo '<div class="entry-content">';
		echo do_shortcode('[template id="'.$post->ID.'"]');
		echo '</div>';
	} else {
	?>

			<div class="entry-content portfolio-details-section-inner events-inner">
			<?php
			if ( !post_password_required() ) {
			?>
				<?php
				if ( !$page_builder_mode ) {
				?>
				<div class="portfolio-content-summary">
				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post();
				the_content();
				endwhile;
				?>
				</div>
			<?php
				}
			// end of password check
			}
			echo '</div>';
		}
		do_action('kreativa_display_portfolio_single_navigation');
		?>
	</div>
	<?php
	$mtheme_pagestyle= get_post_meta( $events_page_id , 'pagemeta_pagestyle', true);
	if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
		get_sidebar();
	}
}
?>
<?php get_footer(); ?>