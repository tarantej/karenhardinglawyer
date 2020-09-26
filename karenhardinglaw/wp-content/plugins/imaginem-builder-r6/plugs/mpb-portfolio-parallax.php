<?php
/** Portfolio parallax **/
if(!class_exists('em_portfolio_parallax')) {
		class em_portfolio_parallax extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {
			$the_list = get_terms('types');
			//print_r($the_list);
			// Pull all the Portfolio Categories into an array
			if ($the_list) {
				$portfolio_categories=array();
				//$portfolio_categories[0]="All the items";
				foreach($the_list as $key => $list) {
					if (isSet($list->slug)) {
						$portfolio_categories[$list->slug] = $list->name;
					}
				}
			} else {
				$portfolio_categories[0]="Portfolio Categories not found.";
			}
			$this->portfolio_store($portfolio_categories);

		}

		function portfolio_store($portfolio_categories) {
			$this->the_options['category_list'] = $portfolio_categories;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-screen-desktop',
				'pb_block_icon_color' => '#0074D9',
				'name' => __('Portfolio parallax','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Add a parallax of Portfolio posts','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			/*-----------------------------------------------------------------------------------*/
			/*	Portfolio parallax
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['recent_portfolio_parallax'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a parallax of portfolio items', 'mthemelocal'),
				'params' => array(
			        'limit' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Limit posts', 'mthemelocal'),
			            'desc' => __('Limit the number of posts', 'mthemelocal'),
			        ),
					'worktype_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Enter Work type slugs to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
					),
					'height_type' => array(
						'type' => 'select',
						'label' => __('Height Style', 'mthemelocal'),
						'desc' => __('Height Style', 'mthemelocal'),
						'options' => array(
							'fixed' => 'Fixed',
							'window' => 'Window Height'
						)
					),
			        'height' => array(
			            'std' => '350',
			            'type' => 'text',
			            'label' => __('Height in pixels ( only numerical )', 'mthemelocal'),
			            'desc' => __('Height in pixels', 'mthemelocal'),
			        )
				),
				'shortcode' => '[recent_portfolio_parallax height_type="{{height_type}}" height="{{height}}" limit="{{limit}}" worktype_slugs="{{worktype_slugs}}""]',
				'popup_title' => __('Add a parallax of portfolio items', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['recent_portfolio_parallax'];

			//create the block
			parent::__construct('em_portfolio_parallax', $block_options);
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

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			echo do_shortcode($shortcode);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}