<?php
/** Heading **/
if(!class_exists('em_heading')) {
		class em_heading extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-header',
				'pb_block_icon_color' => '#FF6961',
				'title' => __('Heading','mthemelocal'),
				'name' => __('Heading','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Display Heading','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Heading
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['heading_tag'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Headings', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Heading text', 'mthemelocal'),
						'desc' => __('Heading text', 'mthemelocal'),
					),
					'align' => array(
						'type' => 'select',
						'label' => __('Align text', 'mthemelocal'),
						'desc' => __('Align text', 'mthemelocal'),
						'options' => array(
							'center' => __('Center','mthemelocal'),
							'left' => __('Left','mthemelocal'),
							'right' => __('Right','mthemelocal')
						)
					),
					'size' => array(
						'type' => 'select',
						'label' => __('Heading size', 'mthemelocal'),
						'desc' => __('Heading size', 'mthemelocal'),
						'options' => array(
							'1' => 'h1',
							'2' => 'h2',
							'3' => 'h3',
							'4' => 'h4',
							'5' => 'h5',
							'6' => 'h6'
						)
					),
			        'top' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding Top in pixels', 'mthemelocal'),
			            'desc' => __('Top Spacing', 'mthemelocal'),
			        ),
			        'bottom' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding bottom pixels', 'mthemelocal'),
			            'desc' => __('Bottom Spacing', 'mthemelocal'),
			        )
				),
				'shortcode' => '[heading_tag animated={{animated}} top="{{top}}" bottom="{{bottom}}" size="{{size}}" title="{{title}}" align="{{align}}"]',
				'popup_title' => __('Add Heading', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['heading_tag'];

			//create the block
			parent::__construct('em_heading', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_scripts'));
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
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}