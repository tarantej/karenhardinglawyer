<?php
/** Service **/
if(!class_exists('em_serviceboxes')) {
		class em_serviceboxes extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-note',
				'pb_block_icon_color' => '#F49AC2',
				'name' => __('Services','mthemelocal'),
				'size' => 'span3',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Service Boxes','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Service Boxes
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['serviceboxes'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Service columns. You can add multiple service items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
			    'shortcode' => '[servicebox animated="{{animated}}" column="1" iconborder="{{iconborder}}" iconbackground="{{iconbackground}}" iconplace="{{iconplace}}" boxplace="horizontal" iconcolor="{{iconcolor}}"] [servicebox_item icon="{{icon}}" drawicon={{drawicon}} iconscale="{{iconscale}}" title="{{title}}" link="{{link}}" linktext="{{linktext}}" last_item="no"] {{content}} [/servicebox_item] [/servicebox]',
			    'popup_title' => __('Generate Services', 'mthemelocal'),
			 	'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'iconplace' => array(
						'type' => 'select',
						'label' => __('Icon Placement', 'mthemelocal'),
						'desc' => __('Placement of icon', 'mthemelocal'),
						'options' => array(
							'top' => __('top','mthemelocal'),
							'left' => __('left','mthemelocal')
						)
					),
					'iconborder' => array(
						'type' => 'select',
						'label' => __('iCon Border', 'mthemelocal'),
						'desc' => __('Placement of service boxes', 'mthemelocal'),
						'options' => array(
							'false' => __('Disable','mthemelocal'),
							'true' => __('Enable','mthemelocal')
						)
					),
					'iconcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon color', 'mthemelocal'),
						'desc' => __('Color of icon in hex', 'mthemelocal'),
					),
					'iconbackground' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon background color', 'mthemelocal'),
						'desc' => __('Background color of icon', 'mthemelocal'),
					),
		            'icon' => array(
		                'std' => 'et-icon-strategy',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Choose an icon', 'mthemelocal'),
			            'desc' => __('Pick an icon', 'mthemelocal'),
			            'options' => ''
		            ),
					'drawicon' => array(
						'type' => 'select',
						'label' => __('Animated draw icon', 'mthemelocal'),
						'desc' => __('Display by drawing the icon', 'mthemelocal'),
						'options' => array(
							'static' => __('Static','mthemelocal'),
							'draw' => __('Draw','mthemelocal')
						)
					),
					'iconscale' => array(
						'type' => 'select',
						'label' => __('Icon Size', 'mthemelocal'),
						'desc' => __('Icon Size', 'mthemelocal'),
						'options' => array(
							'small' => __('Small','mthemelocal'),
							'large' => __('Large','mthemelocal')
						)
					),
		            'title' => array(
		                'std' => 'Fusce Magna Elit',
		                'type' => 'text',
		                'label' => __('Service Title', 'mthemelocal'),
		                'desc' => __('Title of the service', 'mthemelocal'),
		            ),
		            'link' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Link', 'mthemelocal'),
		                'desc' => __('Link to title', 'mthemelocal'),
		            ),
		            'linktext' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Text for link', 'mthemelocal'),
		                'desc' => __('Text for link', 'mthemelocal'),
		            ),
		            'content' => array(
		                'std' => __('Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.','mthemelocal'),
		                'type' => 'editor',
		                'label' => __('Service Content', 'mthemelocal'),
		                'desc' => __('Add the service content', 'mthemelocal')
		            )
				),
			);


			$this->the_options = $mtheme_shortcodes['serviceboxes'];

			//create the block
			parent::__construct('em_serviceboxes', $block_options);
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

			wp_enqueue_script ('jquery-vivus');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			echo do_shortcode($shortcode);
			
		}
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}