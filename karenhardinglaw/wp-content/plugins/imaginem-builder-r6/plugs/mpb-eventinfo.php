<?php
/** Alerts **/
if(!class_exists('em_eventinfo')) {
		class em_eventinfo extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-info',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Event Infobox','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add event information box','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Alert Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['eventinfobox'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Event information box', 'mthemelocal'),
				'params' => array(
					'style' => array(
						'type' => 'select',
						'label' => __('Event Style', 'mthemelocal'),
						'desc' => __('Select event style', 'mthemelocal'),
						'options' => array(
							'column' => __('Column','mthemelocal'),
							'centered' => __('Centered','mthemelocal'),
							'list' => __('List','mthemelocal')
						)
					)
					
				),
				'shortcode' => '[eventinfobox type="{{style}}"]',
				'popup_title' => __('Add Event infobox', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['eventinfobox'];

			//create the block
			parent::__construct('em_eventinfo', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_fontawesomeBlock'));
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
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}