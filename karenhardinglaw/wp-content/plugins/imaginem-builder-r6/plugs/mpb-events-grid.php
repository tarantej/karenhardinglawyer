<?php
/** Events Grid **/
if(!class_exists('em_events_grid')) {
		class em_events_grid extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {
			$the_list = get_terms('types');
			//print_r($the_list);
			// Pull all the Events Categories into an array
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
				'name' => __('Events Grid','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Portfolio','mthemelocal'),
				'desc' => __('Generate an Events Grid','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			$mtheme_shortcodes['gridcreate'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('A Grid based list of portfolio items.', 'mthemelocal'),
				'params' => array(
					'format' => array(
						'type' => 'select',
						'label' => __('Image orientation format', 'mthemelocal'),
						'desc' => __('Image orientation format', 'mthemelocal'),
						'options' => array(
							'landscape' => __('Landscape','mthemelocal'),
							'portrait' => __('Portrait','mthemelocal')
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
					'event_status' => array(
						'type' => 'select',
						'label' => __('Event Status', 'mthemelocal'),
						'desc' => __('Event Status', 'mthemelocal'),
						'options' => array(
							'allevents' => __('All Events','mthemelocal'),
							'postponed' => __('Postponed','mthemelocal'),
							'cancelled' => __('Cancelled','mthemelocal'),
							'pastevent' => __('Past Events','mthemelocal')
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
				'shortcode' => '[gridcreate grid_post_type="mtheme_events" grid_tax_type="tagevents" boxtitle="false" worktype_slugs="" event_status="{{event_status}}" format="{{format}}" columns="{{columns}}" type="default" limit="{{limit}}" pagination="{{pagination}}" title="{{title}}" desc="{{desc}}"]',
				'popup_title' => __('Add Events Grid', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['gridcreate'];

			//create the block
			parent::__construct('em_events_grid', $block_options);
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
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			echo do_shortcode($shortcode);
			
		}
		function mtheme_enqueue_em_events_grid(){
			//Any script registers go here
		}

	}
}