<?php
/**
 * Swiper Slides
 *
 */
if(!class_exists('em_swiperslides')) {
	class em_swiperslides extends AQ_Block {
		public function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-screen-desktop',
				'pb_block_icon_color' => '#836953',
				'name' => __('Swiper Slides','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add a Swiper Slides','mthemelocal')
			);

			$mtheme_shortcodes['swiperslides'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate Swiper Slides', 'mthemelocal'),
				'params' => array(
					'pb_image_ids' => array(
						'type' => 'images',
						'label' => __('Add images', 'mthemelocal'),
						'desc' => __('Add images', 'mthemelocal'),
					),
					'lightbox' => array(
						'type' => 'select',
						'std' => 'false',
						'label' => __('Lightbox', 'mthemelocal'),
						'desc' => __('Lightbox', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'true' => __('Yes','mthemelocal')
						)
					)
				),
				'shortcode' => '[swiperslides lightbox="{{lightbox}}" pb_image_ids="{{pb_image_ids}}"]',
				'popup_title' => __('Add Swiper Slides', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['swiperslides'];

			parent::__construct('em_swiperslides', $block_options);
		}

		public function form( $instance ) {
			$instance = $this->set_defaults($instance);
			$this->admin_enqueue();
			// $ids = implode( ',', $instance['ids'] );
			// $layouts = array(
			// 	'layout1' => 'Layout 1',
			// 	'layout2' => 'Layout 2',
			// 	'layout3' => 'Layout 3',
			// 	'layout4' => 'Layout 4',
			// );

			echo mtheme_generate_builder_form($this->the_options,$instance);
			?>
			
			<?php
		}

		// public function update( $new_instance, $old_instance ) {
		// 		$new_instance['ids'] = explode( ',', $new_instance['ids'] );
		// 	return parent::update( $new_instance, $old_instance );
		// }

		protected function admin_enqueue() {
		}

		protected function wp_enqueue() {

		}

		public function block( $instance ) {
			//$this->set_defaults( $instance );
			// if ( ! empty( $instance['ids'] ) )
			// 	echo mtheme_get_gallery( $instance['ids'], $instance['layout'] );
			extract($instance);

			wp_enqueue_script ('jquery-swiper');
			wp_enqueue_style ('jquery-swiper');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			//echo $shortcode;
			echo do_shortcode($shortcode);
		}

		protected function set_defaults($instance) {
			return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
		}
	}
}