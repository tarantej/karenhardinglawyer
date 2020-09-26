<?php
/*
 Single Portfolio Page
*/
?>
<?php get_header(); ?>
<?php
/**
*  Portfolio Loop
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
		$portfolio_page_header="";
		$portfolio_client="";
		$portfolio_projectlink="";
		$portfolio_client_link="";
		
		$custom = get_post_custom($post->ID);
		$mtheme_pagestyle="fullwidth";
		if (isset($custom['pagemeta_pagestyle'][0])) $mtheme_pagestyle=$custom['pagemeta_pagestyle'][0];
		if (isset($custom['pagemeta_portfoliotype'][0])) $portfolio_page_header=$custom['pagemeta_portfoliotype'][0];
		if (isset($custom['pagemeta_video_embed'][0])) $portfolio_videoembed=$custom['pagemeta_video_embed'][0];
		if (isset($custom['pagemeta_customlink'][0])) $custom_link=$custom['pagemeta_customlink'][0];
		if (isset($custom['pagemeta_clientname'][0])) $portfolio_client=$custom['pagemeta_clientname'][0];
		if (isset($custom['pagemeta_clientname_link'][0])) $portfolio_client_link=$custom['pagemeta_clientname_link'][0];
		if (isset($custom['pagemeta_projectlink'][0])) $portfolio_projectlink=$custom['pagemeta_projectlink'][0];
		if (isset($custom['pagemeta_skills_required'][0])) $portfolio_skills_required=$custom['pagemeta_skills_required'][0];

		if ( isset($custom['pagemeta_ajax_description'][0])) {
			$description=$custom['pagemeta_ajax_description'][0];
			$description=nl2br($description);
		}

		$floatside="float-right";
		$two_column='two-column';
		$floatside_portfolio="float-right";
		$fullwidth_column='';
		$floatside_portfolio_opp = "float-left";
		$found_a_page_style = false;
		if ($mtheme_pagestyle=="edge-to-edge") {
			$floatside="";
			$two_column="";
			$fullwidth_column="edge-to-edge-column";
			$floatside_portfolio = "";
			$floatside_portfolio_opp = "";
			$found_a_page_style = true;
		}
		if ($mtheme_pagestyle=="fullwidth") {
			$floatside="";
			$two_column="";
			$fullwidth_column="fullwidth-column";
			$floatside_portfolio = "";
			$floatside_portfolio_opp = "";
			$found_a_page_style = true;
		}
		if ($mtheme_pagestyle=="rightsidebar") {
			$floatside="float-left";
			$floatside_portfolio = $floatside;
			$floatside_portfolio_opp = "float-right";
			$found_a_page_style = true;
		}
		if ($mtheme_pagestyle=="leftsidebar") {
			$floatside="float-right";
			$floatside_portfolio = $floatside;
			$floatside_portfolio_opp = "float-left";
			$found_a_page_style = true;
		}
		if (!$found_a_page_style) {
			// if a choice of page style is not set then set defaults.
			$mtheme_pagestyle="fullwidth";
			$floatside="";
			$two_column="";
			$fullwidth_column="fullwidth-column";
			$floatside_portfolio = "";
			$floatside_portfolio_opp = "";
			$found_a_page_style = true;
		}

		if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
			$mtheme_pagestyle="rightsidebar";
			$floatside="float-left";
		}
		if ( post_password_required() ) {
			$mtheme_pagestyle="";
			$floatside="";
			$two_column="";
		}

		if ( post_password_required() ) {
			$two_column="";
			$floatside_portfolio="";
		}

		$image_size_type = "kreativa-gridblock-full";
		if ( $two_column == "two-column" ) {
			$image_size_type = "kreativa-gridblock-full";
		}
?>
	<div class="portfolio-header-wrap <?php echo esc_attr($fullwidth_column); ?> clearfix">
		<div class="portfolio-header-left entry-content <?php echo esc_attr($mtheme_pagestyle) . ' ' . esc_attr($two_column); ?> <?php echo esc_attr($floatside_portfolio); ?>">
		<?php
		$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
		$page_builder_mode = false;
		if (isSet($isactive) && $isactive==1) {
			$page_builder_mode = true;
		}
		if (!$page_builder_mode) {
			if ( ! post_password_required() ) {
				
				if ( has_post_thumbnail() ) {
					echo '<div class="portfolio-header-section">';
					echo kreativa_display_post_image (
						get_the_ID(),
						$have_image_url=false,
						$link=false,
						$type="fullwidth",
						$post->post_title,
						$class="portfolio-single-image" 
					);
						echo '</div>';
				}
			}
		}
		if ($page_builder_mode) {
			if ($mtheme_pagestyle !="rightsidebar" && $mtheme_pagestyle !="leftsidebar" ) {
				$mtheme_pagestyle='';
			}
		}
		?>
						
				<div class="entry-portfolio-content entry-content clearfix">
				<?php
				if ( post_password_required() ) {
					echo '<div class="entry-content" id="password-protected">';
					echo '<span class="password-protected-icon"><i class="ion-ios-locked-outline"></i></span>';
					echo get_the_password_form();
					do_action('kreativa_demo_password');
					echo '</div>';
				} else {
					if ($page_builder_mode) {
						echo do_shortcode('[template id="'.$post->ID.'"]');
					} else {
						if ( have_posts() ) while ( have_posts() ) : the_post();
							the_content();
						endwhile;
					}
				}
				?>
				</div>

			</div>
		<?php
				if ( ! post_password_required() ) {
					global $mtheme_pagestyle;
					if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
						get_sidebar();
					}
				}
		?>
		</div>
		<?php
		if ( ! post_password_required() ) {
		if (kreativa_get_option_data('portfolio_comments')) {
			if ( comments_open() ) {
			?>
			<div class="portfolio-header-wrap entry-content clearfix">
				<div class="two-column float-left">
				<?php
					comments_template();
				?>
				</div>
			</div>
			<?php
			}
		}
		}
		?>
	</div>
<?php get_footer(); ?>