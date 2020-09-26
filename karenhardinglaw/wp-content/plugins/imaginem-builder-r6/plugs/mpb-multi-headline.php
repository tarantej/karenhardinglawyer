<?php
/** Richtext **/
if(!class_exists('em_multiheadline')) {
		class em_multiheadline extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pencil',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Multi Headline','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Multi Headline','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['multiheadline'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
					'content_richtext' => array(
						'std' => __('Content','mthemelocal'),
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Multi headline Text', 'mthemelocal'),
						'desc' => __('Add the content', 'mthemelocal'),
					),
					'margin_bottom' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Margin bottom in pixels', 'mthemelocal'),
						'desc' => __('Margin bottom in pixels', 'mthemelocal')
					),
				),
				'shortcode' => '[multiheadline margin_bottom="{{margin_bottom}}" content_richtext="{{content_richtext}}"]',
				'popup_title' => __('Add Multi Headlines', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['multiheadline'];

			//create the block
			parent::__construct('em_multiheadline', $block_options);
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