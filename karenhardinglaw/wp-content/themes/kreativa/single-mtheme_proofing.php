<?php
/*
*  Page
*/
?>
<?php get_header(); ?>
<?php
$custom = get_post_custom($post->ID);
$proofing_status = '';
$dont_show_page = false;
$proofing_proofing_column = '3';
$proofing_proofing_format = 'landscape';
if (isset($custom['pagemeta_proofing_status'][0])) $proofing_status=$custom['pagemeta_proofing_status'][0];
if (isset($custom['pagemeta_proofing_startdate'][0])) $proofing_startdate=$custom['pagemeta_proofing_startdate'][0];
if (isset($custom['pagemeta_proofing_client'][0])) $proofing_client=$custom['pagemeta_proofing_client'][0];
if (isset($custom['pagemeta_proofing_location'][0])) $proofing_location=$custom['pagemeta_proofing_location'][0];
if (isset($custom['pagemeta_proofing_column'][0])) $proofing_proofing_column=$custom['pagemeta_proofing_column'][0];
if (isset($custom['pagemeta_proofing_format'][0])) $proofing_proofing_format=$custom['pagemeta_proofing_format'][0];
if (isset($custom['pagemeta_proofing_download'][0])) $proofing_download=$custom['pagemeta_proofing_download'][0];
if (isset($custom['pagemeta_client_names'][0])) $client_id=$custom['pagemeta_client_names'][0];

if (isSet($proofing_startdate)) {
	$proofing_startdate = str_replace('-', '/', $proofing_startdate);
	$proofing_startdate = date_i18n( get_option( 'date_format' ), strtotime($proofing_startdate) );
} else {
	$proofing_startdate = '';
}

if ( isSet($client_id) && post_password_required($client_id) ) {
	$dont_show_page = true;
}
if ( $proofing_status == "inactive" ) {
	$dont_show_page = true;
}

if ( $dont_show_page ) {
		echo '<div id="vertical-center-wrap">';
			echo '<div class="vertical-center-outer">';
				echo '<div class="vertical-center-inner">';
					echo '<div class="entry-content client-gallery-protected" id="password-protected">';
					echo kreativa_display_client_details($client_id,$summary=false);
					if ( $proofing_status <> "inactive" ) {
						echo '<div class="client-gallery-password-form is-animated animated flipInX">';
						echo get_the_password_form($client_id);
						do_action('kreativa_demo_password');
						echo '</div>';
					}
					if ( $proofing_status == "inactive" ) {
						echo '<div class="proofing-restricted is-animated animated flipInX">';
						echo 'Please contact us to activate this proofing gallery';
						echo '</div>';
					}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	} else {

	$filter_image_ids = kreativa_get_custom_attachments ( get_the_id() );
	?>
	<div class="page-contents-wrap entry-content">
			<div class="proofing-content-wrap">
				<div class="proofing-content">
					<?php
					$proofing_locked_msg = esc_html__("Proofing gallery selection has been locked.","kreativa");
					$proofing_active_msg = esc_html__("Proofing gallery is active for selection.","kreativa");

					$proofing_disable_msg = esc_html__("Please contact us to activate this proofing gallery.","kreativa");
					$proofing_download_msg = esc_html__("Proofing gallery Locked for Download.","kreativa");
					if ( post_password_required() ) {
						// If password
					} else {
							if ( isSet($client_id) && $client_id<>"" && $client_id<>"none" ) {
								echo '<div class="entry-content client-gallery-details proofing-client-details">';
								echo '<div class="proofing-client-details-inner">';
								echo kreativa_display_client_details( $client_id , $title = true , $desc = true , $eventdetails=true , $proofing_id = get_the_id() , $pagetitle = true );
								if ( isSet($proofing_download) && $proofing_download <>"" && $proofing_status == "download") {
								$button_style = "";
								?>
								<div class="button-shortcode <?php echo esc_attr($button_style); ?> proofing-gallery-button">
									<a target="_blank" href="<?php echo esc_url($proofing_download); ?>">
										<div class="mtheme-button big-button">
											<i class="fa fa-download"></i> <?php esc_html_e('Download','kreativa'); ?>
										</div>
									</a>
								</div>
								<?php
								}
								echo '</div>';
								echo '</div>';
							}
						?>
					<?php
					// end of password check
					}
					?>
				</div>
			</div>
	<?php
	if ( !post_password_required() && $proofing_status<>"inactive" ) {
		if ($filter_image_ids) {
			echo do_shortcode('[proofing_gallery columns="'.$proofing_proofing_column.'" format="'.$proofing_proofing_format.'" proofingstatus="'.$proofing_status.'" padeid=""]');
		}
	}
	if ($proofing_status<>"inactive") {
		if ( have_posts() ) while ( have_posts() ) : the_post();
		the_content();
		endwhile;
	}
	?>
	<?php
	if ( !post_password_required() ) {
	?>
	<?php
	if ( $proofing_status<>"inactive" ) {
		comments_template();
	}
	?>
	</div>
	<?php
	}
}
?>
<?php get_footer(); ?>