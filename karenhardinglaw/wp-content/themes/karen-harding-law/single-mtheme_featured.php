<?php
//Defined in Theme Framework functions
$featured_page = get_the_ID();
$custom = get_post_custom( get_the_ID() );
if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) {
	$fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
	$fullscreen_post_load = kreativa_get_fullscreen_file($fullscreen_type);
}
if (isSet($fullscreen_post_load)) {
	switch ($fullscreen_post_load) {
		case "photowall" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'photowall' );
		break;

		case "kenburns" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'kenburns' );
		break;

		case "coverphoto" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'coverphoto' );
		break;

		case "particles" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'particles' );
		break;

		case "fotorama" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'fotorama' );
		break;

		case "carousel" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'carousel' );
		break;
		
		case "supersized" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'supersized' );
		break;
		
		case "video" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'video' );
		break;

		case "revslider" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'revslider' );
		break;

		case "swiperslides" :
			get_template_part('/template-parts/fullscreen/fullscreen', 'swiperslides' );
		break;
		default:
		break;
	}
} else {
	get_header();
	?>
	<div class="container-wrapper container-boxed"> 
		<div class="page-contents-wrap">
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-page-wrapper entry-content clearfix">
					<div class="title-container-wrap">
						<div class="title-container clearfix">
							<div class="entry-title fullscreen-not-found">
							<?php
							echo esc_html__('<h1>Fullscreen type not found.</h1>','kreativa');
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	get_footer();
}
?>