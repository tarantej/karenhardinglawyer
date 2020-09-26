<?php
/** Blog Photocard **/
if(!class_exists('em_blog_parallax')) {
		class em_blog_parallax extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {

			$cat_slugs = array();
			$blog_cat_slugs_obj = get_categories();
			if ($blog_cat_slugs_obj) {
				foreach ($blog_cat_slugs_obj as $category) {
					$cat_slugs[$category->slug] = $category->slug;
				}
			} else {
				$cat_slugs[0]="Blog Categories not found.";
			}
			$this->category_store($cat_slugs);

		}

		function category_store($cat_slugs) {
			$this->the_options['category_list'] = $cat_slugs;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-camera',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Blog Parallax','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Posts','mthemelocal'),
				'desc' => __('Display blog as parallax','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));


			/*-----------------------------------------------------------------------------------*/
			/*	Recent Blog List boxes
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['blog_photo'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display bloglist.', 'mthemelocal'),
				'params' => array(
					'cat_slug' => array(
						'type' => 'category_list',
						'label' => __('Choose Category to list', 'mthemelocal'),
						'desc' => __('Choose Category to list', 'mthemelocal'),
						'options' => ''
					),
					'post_type' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Comma seperated post types or a single post type.', 'mthemelocal'),
						'desc' => __('audio,gallery,aside,quote,video,image,standard', 'mthemelocal'),
					),
					'readmore_text' => array(
						'std' => __('Continue reading', 'mthemelocal'),
						'type' => 'text',
						'label' => __('Read more text', 'mthemelocal'),
						'desc' => __('Read more text', 'mthemelocal'),
					),
					'height_type' => array(
						'type' => 'select',
						'label' => __('Height Style', 'mthemelocal'),
						'desc' => __('Height Style', 'mthemelocal'),
						'options' => array(
							'fixed' => 'Fixed',
							'window' => 'Window Height'
						)
					),
			        'height' => array(
			            'std' => '350',
			            'type' => 'text',
			            'label' => __('Height in pixels ( only numerical )', 'mthemelocal'),
			            'desc' => __('Height in pixels', 'mthemelocal'),
			        )
				),
				'shortcode' => '[blog_parallax cat_slug="{{cat_slug}}" readmore_text="{{readmore_text}}" height_type="{{height_type}}" height="{{height}}" post_type="{{post_type}}"]',
				'popup_title' => __('Display blog as Parallax', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['blog_photo'];

			//create the block
			parent::__construct('em_blog_parallax', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_Block'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel');
			wp_enqueue_script ('jquery-jplayer');
			wp_enqueue_style ('jquery-jplayer');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			echo do_shortcode($shortcode);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}