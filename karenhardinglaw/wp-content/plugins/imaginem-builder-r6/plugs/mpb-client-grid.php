<?php
/** PhotoStory Grid **/
if(!class_exists('em_client_grid')) {
		class em_client_grid extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-grid',
				'pb_block_icon_color' => '#836953',
				'name' => __('Client Grid','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Generate a Client Grid','mthemelocal')
			);

			$mtheme_shortcodes['clientgrid'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('A Grid based list of clients.', 'mthemelocal'),
				'params' => array(
					'format' => array(
						'type' => 'select',
						'label' => __('Image orientation format', 'mthemelocal'),
						'desc' => __('Image orientation format', 'mthemelocal'),
						'options' => array(
							'landscape' => __('Landscape','mthemelocal'),
							'portrait' => __('Portrait','mthemelocal'),
							'masonary' => __('Masonry','mthemelocal')
						)
					),
					'gutter' => array(
						'type' => 'select',
						'label' => __('Gutter Space', 'mthemelocal'),
						'desc' => __('Gutter Space', 'mthemelocal'),
						'options' => array(
							'spaced' => __('Spaced','mthemelocal'),
							'nospace' => __('No Space','mthemelocal')
						)
					),
					'columns' => array(
						'type' => 'select',
						'label' => __('Grid Columns', 'mthemelocal'),
						'desc' => __('No. of Grid Columns', 'mthemelocal'),
						'options' => array(
							'4' => '4',
							'3' => '3',
							'2' => '2',
							'1' => '1'
						)
					),
					'boxtitle' => array(
						'type' => 'select',
						'label' => __('Box title and category', 'mthemelocal'),
						'desc' => __('Box title and category', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'true' => __('Yes','mthemelocal')
						)
					),
					'title' => array(
						'type' => 'select',
						'label' => __('Display post title', 'mthemelocal'),
						'desc' => __('Display post title', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'limit' => array(
						'std' => '-1',
						'type' => 'text',
						'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
						'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
					),
					'pagination' => array(
						'type' => 'select',
						'label' => __('Generate Pagination', 'mthemelocal'),
						'desc' => __('Generate Pagination', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					)
				),
				'shortcode' => '[gallerygrid grid_post_type="mtheme_clients" grid_taxonomy="" displaycategory="false" boxtitle="{{boxtitle}}" gutter="{{gutter}}" columns="{{columns}}" format="{{format}}" worktype_slugs="{{worktype_slugs}}" title="{{title}}" desc="{{desc}}" pagination="{{pagination}}" limit="{{limit}}"]',
				'popup_title' => __('Add Client Grid', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['clientgrid'];

			//create the block
			parent::__construct('em_client_grid', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_Block'));
			
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('isotope');
			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel');
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			echo do_shortcode($shortcode);
			
		}
		function mtheme_enqueue_em_client_grid(){
			//Any script registers go here
		}

	}
}