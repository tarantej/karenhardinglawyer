<?php
/** Richtext **/
if(!class_exists('em_checklist')) {
		class em_checklist extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pencil',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Unordered List','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Unordered list','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['checklist'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
			        'icon' => array(
			            'std' => 'fa fa-ok',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
			        ),
					'iconcolor' => array(
						'std' => '#EC3939',
						'type' => 'color',
						'label' => __('Icon color', 'mthemelocal'),
						'desc' => __('Icon color in hex', 'mthemelocal'),
					),
					'content_richtext' => array(
						'std' => __('<ul><li>Lorem ipsum</li></ul>','mthemelocal'),
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('List', 'mthemelocal'),
						'desc' => __('Add the content', 'mthemelocal'),
					),
				),
				'shortcode' => '[checklist icon="{{icon}}" color="{{iconcolor}}" content_richtext="{{content_richtext}}"]',
				'popup_title' => __('Add Checklist', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['checklist'];

			//create the block
			parent::__construct('em_checklist', $block_options);
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