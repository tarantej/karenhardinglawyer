<?php
/** Social Icons **/
if(!class_exists('em_sidebar')) {
		class em_sidebar extends AQ_Block {

		protected $the_options;
		protected $sidebars;

		function init_reg() {
			global $wp_registered_sidebars;

		    if ( empty( $wp_registered_sidebars ) )
		        return;

		    foreach ( $wp_registered_sidebars as $sidebar ) :
		            $sidebars[$sidebar['id']] = $sidebar['name'];  
		    endforeach;
			$this->sidebar_lister($sidebars);

		}

		function sidebar_lister($sidebars) {
			$this->the_options['sidebar_list'] = $sidebars;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-notebook',
				'pb_block_icon_color' => '#0074D9',
				'name' => __('Sidebar','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Sidebar','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			$mtheme_shortcodes['sidebar'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a Social link', 'mthemelocal'),
				'params' => array(
					'sidebar_choices' => array(
						'type' => 'sidebar_list',
						'std' => '',
						'label' => __('Choose Widgetized Sidebars', 'mthemelocal'),
						'desc' => __('Choose Widgetized Sidebars', 'mthemelocal'),
						'options' => ''
					)
				),
				'shortcode' => '[sidebar sidebar_choice="{{sidebar_choices}}"]',
				'popup_title' => __('Add a Sidebar', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['sidebar'];

			//create the block
			parent::__construct('em_sidebar', $block_options);
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

			$the_sidebar = $instance['mtheme_sidebar_choices'];

			if (isSet($the_sidebar)) {
				if ( is_active_sidebar( $the_sidebar ) ) {
					echo '<div id="sidebar" class="sidebar-pagebuilder">';
						echo '<div class="sidebar">';
							dynamic_sidebar($the_sidebar);
						echo '</div>';
					echo '</div>';
				}
			}
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}