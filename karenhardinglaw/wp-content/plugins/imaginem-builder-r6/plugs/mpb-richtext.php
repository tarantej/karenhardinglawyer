<?php
/** Richtext **/
if(!class_exists('em_displayrichtext')) {
		class em_displayrichtext extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pencil',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Richtext Box','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Richtext','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['displayrichtext'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'content_richtext' => array(
						'std' => __('Content','mthemelocal'),
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Rich Text', 'mthemelocal'),
						'desc' => __('Add the content', 'mthemelocal'),
					),
					
				),
				'shortcode' => '[displayrichtext content_richtext="{{content_richtext}}"]',
				'popup_title' => __('Add Richtext', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['displayrichtext'];

			//create the block
			parent::__construct('em_displayrichtext', $block_options);
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

			// echo '<pre>';
			// print_r($instance);
			// echo '</pre>';
			if (isSet($instance['mtheme_animated'])) {
				$animated = $instance['mtheme_animated'];
			}
			$the_shortcode = $instance['mtheme_content_richtext'];
			//$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			// echo '<pre>----the shortcode';
			// echo htmlentities($shortcode);
			// echo '</pre>';
			// 
			if ( !isSet($animated) ) {
				$animated = "none";
			}
			$the_shortcode = wpautop( $the_shortcode, true );
			echo '<div class="animation-standby animated '.$animated.'">';
			echo do_shortcode($the_shortcode);
			echo '</div>';
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}