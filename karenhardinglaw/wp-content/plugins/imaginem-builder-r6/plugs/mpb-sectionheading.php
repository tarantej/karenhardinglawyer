<?php
/** Section Heading **/
if(!class_exists('em_sectionheading')) {
		class em_sectionheading extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-header',
				'pb_block_icon_color' => '#FF6961',
				'title' => __('Section Heading','mthemelocal'),
				'name' => __('Section Heading','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Display Section Heading','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Heading
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['heading'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Section Headings', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'headingstyle' => array(
						'type' => 'select',
						'label' => __('Section style', 'mthemelocal'),
						'desc' => __('Section style', 'mthemelocal'),
						'options' => array(
							'default' => __('Default','mthemelocal'),
							'compact' => __('Compact','mthemelocal')
						)
					),
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Section Heading text', 'mthemelocal'),
						'desc' => __('Section Heading text', 'mthemelocal'),
					),
					'titlecolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Title color', 'mthemelocal'),
						'desc' => __('Title color', 'mthemelocal'),
					),
					'description' => array(
						'std' => '',
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Description (optional)', 'mthemelocal'),
						'desc' => __('Description text', 'mthemelocal'),
					),
					'descstyle' => array(
						'type' => 'select',
						'label' => __('Description style', 'mthemelocal'),
						'desc' => __('Description style', 'mthemelocal'),
						'options' => array(
							'none' => __('None','mthemelocal'),
							'fill' => __('Fill','mthemelocal'),
							'boxborder' => __('Box Border','mthemelocal'),
							'bordertop' => __('Border top','mthemelocal'),
							'borderbottom' => __('Border bottom','mthemelocal'),
							'bordertopbottom' => __('Border top and bottom','mthemelocal')
						)
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
							'1' => 'H1',
							'2' => 'H2',
							'3' => 'H3',
							'4' => 'H4',
							'5' => 'H5',
							'6' => 'H6'
						)
					),
			        'customfontsize' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Custom Title Size in px', 'mthemelocal'),
			            'desc' => __('Custom Title Size in px', 'mthemelocal'),
			        ),
			        'customfontweight' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Custom Title Weight', 'mthemelocal'),
			            'desc' => __('Custom Title Weight ( 100, 200, 300, 400, 500, 600, 700, 800, 900 )', 'mthemelocal'),
			        ),
			        'titlebottomspace' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Bottom of Title Space', 'mthemelocal'),
			            'desc' => __('Bottom of Title Space in pixels', 'mthemelocal'),
			        ),
			        'width' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Width in percent', 'mthemelocal'),
			            'desc' => __('Width in percent', 'mthemelocal'),
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
			        ),
			        'marginbottom' => array(
			            'std' => '60',
			            'type' => 'text',
			            'label' => __('Margin bottom pixels', 'mthemelocal'),
			            'desc' => __('Margin Bottom Spacing', 'mthemelocal'),
			        )
				),
				'shortcode' => '[heading animated={{animated}} titlebottomspace="{{titlebottomspace}}" headingstyle="{{headingstyle}}" customfontweight="{{customfontweight}}" customfontsize="{{customfontsize}}" marginbottom="{{marginbottom}}" width="{{width}}" descstyle="{{descstyle}}" description="{{description}}" top="{{top}}" bottom="{{bottom}}" size="{{size}}" title="{{title}}" titlecolor="{{titlecolor}}" align="{{align}}"]',
				'popup_title' => __('Insert Section Heading', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['heading'];

			//create the block
			parent::__construct('em_sectionheading', $block_options);
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