<?php
/*
*  Page
*/
?>
<?php get_header(); ?>
<?php
if ( post_password_required() ) {
	echo '<div class="entry-content" id="password-protected">';
	echo get_the_password_form();
	do_action('kreativa_demo_password');
	echo '</div>';
} else {
	$floatside='';
	$mtheme_pagestyle="nosidebar";

	$mtheme_pagestyle= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" || empty($mtheme_pagestyle) ) {
		$mtheme_pagestyle="nosidebar";
	}
	$sidebar_present = false;
	if ($mtheme_pagestyle=="nosidebar") { $floatside=""; }
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; $sidebar_present=true;}
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; $sidebar_present=true;}

	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
		$mtheme_pagestyle="rightsidebar";
		$floatside="float-left";
	}
	if ( $mtheme_pagestyle=="edge-to-edge") {
		$floatside='';
		$mtheme_pagestyle='nosidebar';
	}
	?>
	<div class="page-contents-wrap <?php echo esc_attr($floatside); ?> <?php if ($sidebar_present) { echo 'two-column'; } ?>">
	<?php
	get_template_part( 'loop', 'page' );
	?>
	</div>
	<?php
	if ($sidebar_present) {
		get_sidebar();
	}
}
?>
<?php get_footer(); ?>