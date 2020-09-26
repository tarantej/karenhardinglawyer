<?php
/** Photocard **/
if(!class_exists('em_photocard_two')) {
		class em_photocard_two extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-camera',
				'pb_block_icon_color' => '#966FD6',
				'name' => __('Photo Textbox','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add a Photocard','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Photocard
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['photocard_two'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a Photocard', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'background_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Textbox Background color', 'mthemelocal'),
						'desc' => __('Textbox Background color', 'mthemelocal'),
					),
					'image_block' => array(
						'type' => 'select',
						'label' => __('Message Box', 'mthemelocal'),
						'desc' => __('Message Box', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'center' => __('Center','mthemelocal'),
							'right' => __('Right','mthemelocal')
						)
					),
			        'image' => array(
			            'std' => '',
			            'type' => 'uploader',
			            'label' => __('Add image', 'mthemelocal'),
			            'desc' => __('Upload image', 'mthemelocal'),
			        ),
			        'video_mp4' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('MP4', 'mthemelocal'),
			            'desc' => __('MP4 url.', 'mthemelocal'),
			        ),
			        'video_webm' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('WEBM', 'mthemelocal'),
			            'desc' => __('WEBM url', 'mthemelocal'),
			        ),
			        'video_ogv' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('OGV', 'mthemelocal'),
			            'desc' => __('OGV url', 'mthemelocal'),
			        ),
			        'imageid' => array(
			            'std' => '',
			            'type' => 'sleeper',
			            'label' => __('Add image', 'mthemelocal'),
			            'desc' => __('Upload image', 'mthemelocal'),
			        ),
					'content_color' => array(
						'type' => 'select',
						'label' => __('Content Color', 'mthemelocal'),
						'desc' => __('Content Color', 'mthemelocal'),
						'options' => array(
							'default' => __('Default','mthemelocal'),
							'dark' => __('Dark','mthemelocal'),
							'bright' => __('Bright','mthemelocal')
						)
					),
					'text_align' => array(
						'type' => 'select',
						'label' => __('Text align', 'mthemelocal'),
						'desc' => __('Text align', 'mthemelocal'),
						'options' => array(
							'center' => __('center','mthemelocal'),
							'left' => __('left','mthemelocal'),
							'right' => __('right','mthemelocal')
						)
					),
			        'title' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Title Text', 'mthemelocal'),
			            'desc' => __('Title Text', 'mthemelocal'),
			        ),
			        'subtitle' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Subtitle text', 'mthemelocal'),
			            'desc' => __('Subtitle text', 'mthemelocal'),
			        ),
			        'button' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button Text', 'mthemelocal'),
			            'desc' => __('Button Text', 'mthemelocal'),
			        ),
			        'button_link' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button link', 'mthemelocal'),
			            'desc' => __('Button link', 'mthemelocal'),
			        ),
			        'content_richtext' => array(
			            'std' => '',
			            'textformat' => 'richtext',
			            'type' => 'editor',
			            'label' => __('Text for contents', 'mthemelocal'),
			            'desc' => __('Text for contents', 'mthemelocal'),
			        ),
				),
				'shortcode' => '[photocard_two animated={{animated}} video_mp4="{{video_mp4}}" video_ogv="{{video_ogv}}" video_webm="{{video_webm}}" background_color="{{background_color}}" content_color="{{content_color}}" imageid="{{imageid}}" image_block="{{image_block}}" text_align="{{text_align}}" button="{{button}}" button_link="{{button_link}}" image="{{image}}" title="{{title}}" subtitle="{{subtitle}}"]{{content_richtext}}[/photocard_two]',
				'popup_title' => __('Add a Photocard', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['photocard_two'];

			//create the block
			parent::__construct('em_photocard_two', $block_options);
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