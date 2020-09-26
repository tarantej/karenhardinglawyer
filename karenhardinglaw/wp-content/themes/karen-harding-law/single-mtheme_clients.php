<?php
/*
*  Page
*/
?>
<?php get_header(); ?>
<?php
if ( post_password_required() ) {
		echo '<div id="vertical-center-wrap">';
			echo '<div class="vertical-center-outer">';
				echo '<div class="vertical-center-inner">';
					echo '<div class="entry-content client-gallery-protected" id="password-protected">';
					echo kreativa_display_client_details( get_the_id() );
					echo '<div class="client-gallery-password-form is-animated animated flipInX">';
						echo get_the_password_form();
						do_action('kreativa_demo_password');
					echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	} else {

	$filter_image_ids = kreativa_get_custom_attachments ( get_the_id() );
	$mtheme_pagestyle= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
	$floatside="float-left";
	$mtheme_pagestyle = "nosidebar";
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
	if ( !post_password_required() ) {
		echo '<div class="entry-content client-gallery-details">';
		echo kreativa_display_client_details( get_the_id() , $title = true, $desc = true );

		echo '<div class="entry-title-wrap-client is-animated animated fadeInUpSlight">';
		echo '<h1 class="entry-title">'.esc_html__('Proofing Galleries','kreativa').'</h1>';
		echo '</div>';

		echo '</div>';
			echo do_shortcode('[clientgrid boxtitle="true" title="false" desc="false" client_id="'.get_the_id().'" columns="2" padeid=""]');
	}
	?>
	</div>
	<?php
	if ( !post_password_required() ) {
	?>
	<?php
		global $mtheme_pagestyle;
		if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
			get_sidebar();
		}
	}
}
?>
<?php get_footer(); ?>