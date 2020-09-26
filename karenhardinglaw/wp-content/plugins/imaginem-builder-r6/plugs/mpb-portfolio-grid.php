<?php
/** Portfolio Grid **/
if(!class_exists('em_portfolio_grid')) {
		class em_portfolio_grid extends AQ_Block {

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
				'pb_block_icon' => 'simpleicon-grid',
				'pb_block_icon_color' => '#836953',
				'name' => __('Portfolio Grid','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Generate a Portfolio Grid','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			$mtheme_shortcodes['portfoliogrid'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('A Grid based list of portfolio items.', 'mthemelocal'),
				'params' => array(
					'worktype_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Choose Work types to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
					),
					'style' => array(
						'type' => 'select',
						'label' => __('Style of Portfolio', 'mthemelocal'),
						'desc' => __('Style of Portfolio', 'mthemelocal'),
						'options' => array(
							'classic' => __('Classic', 'mthemelocal'),
							'wall-spaced' => __('Wall Spaced', 'mthemelocal'),
							'wall-grid' => __('Wall Grid', 'mthemelocal'),
						)
					),
					'effect' => array(
						'type' => 'select',
						'label' => __('Hover Effect', 'mthemelocal'),
						'desc' => __('Hover Effect', 'mthemelocal'),
						'options' => array(
							'default' => __('Default', 'mthemelocal'),
							'tilt' => __('Tilt', 'mthemelocal'),
							'blur' => __('Blur', 'mthemelocal'),
							'zoom' => __('Zoom', 'mthemelocal')
						)
					),
					'type' => array(
						'type' => 'select',
						'label' => __('Type of Portfolio list', 'mthemelocal'),
						'desc' => __('Type of Portfolio list', 'mthemelocal'),
						'options' => array(
							'no-filter' => __('No Filter', 'mthemelocal'),
							'filter' => __('Filterable', 'mthemelocal')
						)
					),
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
					'like' => array(
						'type' => 'select',
						'label' => __('Display like/heart', 'mthemelocal'),
						'desc' => __('Displays like/heart', 'mthemelocal'),
						'options' => array(
							'no' => __('No','mthemelocal'),
							'yes' => __('Yes','mthemelocal')
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
						'label' => __('Wall title', 'mthemelocal'),
						'desc' => __('Wall title', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'box-directlink' => __('Direct link','mthemelocal'),
							'box-lightbox' => __('Lightbox','mthemelocal')
						)
					),
					'title' => array(
						'type' => 'select',
						'label' => __('Classic Title', 'mthemelocal'),
						'desc' => __('Classic title', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'desc' => array(
						'type' => 'select',
						'label' => __('Classic description', 'mthemelocal'),
						'desc' => __('Classic description', 'mthemelocal'),
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
				'shortcode' => '[portfoliogrid effect="{{effect}}" type="{{type}}" style="{{style}}" boxtitle="{{boxtitle}}" like={{like}} columns="{{columns}}" format="{{format}}" worktype_slugs="{{worktype_slugs}}" title="{{title}}" desc="{{desc}}" pagination="{{pagination}}" limit="{{limit}}"]',
				'popup_title' => __('Insert Portfolio Grid Shortcode', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['portfoliogrid'];

			//create the block
			parent::__construct('em_portfolio_grid', $block_options);
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
		function mtheme_enqueue_em_portfolio_grid(){
			//Any script registers go here
		}

	}
}