<?php
/**
 * Thumbnails
 *
 */
class em_vertical_images extends AQ_Block {
	public function __construct() {
		$block_options = array(
			'pb_block_icon' => 'simpleicon-grid',
			'pb_block_icon_color' => '#77DD77',
			'name' => __('Vertical Images','mthemelocal'),
			'size' => 'span12',
			'tab' => __('Media','mthemelocal'),
			'desc' => __('Generate Vertical Images','mthemelocal')
		);

		$mtheme_shortcodes['vertical_images'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Generate a Thumbnail grid using image attachments', 'mthemelocal'),
			'params' => array(
				'animated' => array(
					'type' => 'select',
					'label' => __('On scroll animated', 'mthemelocal'),
					'desc' => __('Display animated images while scrolling', 'mthemelocal'),
					'options' => array(
						'false' => __('No','mthemelocal'),
						'true' => __('Yes','mthemelocal')
					)
				),
				'title' => array(
					'type' => 'select',
					'label' => __('Dispay image title', 'mthemelocal'),
					'desc' => __('Display image title', 'mthemelocal'),
					'options' => array(
						'true' => __('Yes','mthemelocal'),
						'false' => __('No','mthemelocal')
					)
				),
				'description' => array(
					'type' => 'select',
					'label' => __('Display image description', 'mthemelocal'),
					'desc' => __('Display image description', 'mthemelocal'),
					'options' => array(
						'true' => __('Yes','mthemelocal'),
						'false' => __('No','mthemelocal')
					)
				),
				'pb_image_ids' => array(
					'type' => 'images',
					'label' => __('Add images', 'mthemelocal'),
					'desc' => __('Add images', 'mthemelocal'),
				),
			),
			'shortcode' => '[vertical_images animated="{{animated}}" title="{{title}}" pb_image_ids="{{pb_image_ids}}" description="{{description}}"]',
			'popup_title' => __('Insert Vertical Images', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['vertical_images'];

		parent::__construct('em_vertical_images', $block_options);
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

		wp_enqueue_script ('isotope');

		$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
		//echo $shortcode;
		echo do_shortcode($shortcode);
	}

	protected function set_defaults($instance) {
		return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
	}
}