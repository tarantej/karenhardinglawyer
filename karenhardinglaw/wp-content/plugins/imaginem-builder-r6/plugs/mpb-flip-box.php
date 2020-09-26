<?php
/** flipbox **/
if(!class_exists('em_flipbox')) {
		class em_flipbox extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-info',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Flip Box','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a flip box','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Alert Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['alert'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate alert messages using presets icons or custom icon.', 'mthemelocal'),
				'params' => array(
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Heading text', 'mthemelocal'),
						'desc' => __('Heading text', 'mthemelocal'),
					),
					'content' => array(
						'std' => __('Flip box Message 1', 'mthemelocal'),
						'textformat' => 'richtext',
						'type' => 'textarea',
						'type' => 'editor',
						'label' => __('Alert Text', 'mthemelocal'),
						'desc' => __('Add the alert\'s text', 'mthemelocal'),
					),
			        'icon' => array(
			            'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
			        ),
		            'image_front' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Background image 1', 'mthemelocal'),
		                'desc' => __('Background image  1 URL', 'mthemelocal'),
		            ),
		            'image_back' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Background image 2', 'mthemelocal'),
		                'desc' => __('Background image 2 URL', 'mthemelocal'),
		            ),
					'button_text' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Button text', 'mthemelocal'),
						'desc' => __('Button text', 'mthemelocal'),
					),
					'target' => array(
						'type' => 'select',
						'label' => __('Button Target', 'mthemelocal'),
						'desc' => __('_self = open in same window. _blank = open in new window', 'mthemelocal'),
						'options' => array(
							'_self' => 'Default',
							'_blank' => 'New Tab'
						)
					),
		            'button_link' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Link', 'mthemelocal'),
		                'desc' => __('Link', 'mthemelocal'),
		            ),
					
				),
				'shortcode' => '[flipbox title="{{title}}" icon="{{icon}}" target="{{target}}" image_front="{{image_front}}" image_back="{{image_back}}" button_text="{{button_text}}" button_link="{{button_link}}"] {{content}} [/flipbox]',
				'popup_title' => __('Insert Alert', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['alert'];

			//create the block
			parent::__construct('em_flipbox', $block_options);
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