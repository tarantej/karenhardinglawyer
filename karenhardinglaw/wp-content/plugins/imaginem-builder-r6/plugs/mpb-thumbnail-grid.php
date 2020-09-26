<?php
/**
 * Thumbnails
 *
 */
class em_thumbnails extends AQ_Block {
	public function __construct() {
		$block_options = array(
			'pb_block_icon' => 'simpleicon-grid',
			'pb_block_icon_color' => '#77DD77',
			'name' => __('Thumbnails Grid','mthemelocal'),
			'size' => 'span12',
			'tab' => __('Media','mthemelocal'),
			'desc' => __('Generate a Thumbnail Grid','mthemelocal')
		);

		$mtheme_shortcodes['thumbnails'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Generate a Thumbnail grid using image attachments', 'mthemelocal'),
			'params' => array(
				'columns' => array(
					'type' => 'select',
					'label' => __('Grid Columns', 'mthemelocal'),
					'desc' => __('No. of Grid Columns', 'mthemelocal'),
					'options' => array(
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1'
					)
				),
				'style' => array(
					'type' => 'select',
					'label' => __('Style of Thumbnails', 'mthemelocal'),
					'desc' => __('Style of Thumbnails', 'mthemelocal'),
					'options' => array(
						'classic' => __('Classic', 'mthemelocal'),
						'wall-spaced' => __('Wall Spaced', 'mthemelocal'),
						'wall-grid' => __('Wall Grid', 'mthemelocal'),
					)
				),
				'effect' => array(
					'type' => 'select',
					'label' => __('Hover Effect', 'mthemelocal'),
					'desc' => __('Hover Effect', 'mthemelocal'),
					'options' => array(
						'default' => __('Default', 'mthemelocal'),
						'tilt' => __('Tilt', 'mthemelocal'),
						'blur' => __('Blur', 'mthemelocal'),
						'zoom' => __('Zoom', 'mthemelocal')
					)
				),
				'format' => array(
					'type' => 'select',
					'label' => __('Image orientation format', 'mthemelocal'),
					'desc' => __('Image orientation format', 'mthemelocal'),
					'options' => array(
						'landscape' => __('Landscape','mthemelocal'),
						'portrait' => __('Portrait','mthemelocal'),
						'masonary' => __('Masonry','mthemelocal')
					)
				),
				'filter' => array(
					'type' => 'select',
					'label' => __('Filter', 'mthemelocal'),
					'desc' => __('Filter using image tags.', 'mthemelocal'),
					'options' => array(
						'none' => __('none','mthemelocal'),
						'tags' => __('Filter with Tags','mthemelocal')
					)
				),
		        'filterall' => array(
		            'std' => 'All',
		            'type' => 'text',
		            'label' => __('Filter tag for all filters', 'mthemelocal'),
		            'desc' => __('Filter tag for all filters', 'mthemelocal'),
		        ),
				'like' => array(
					'type' => 'select',
					'label' => __('Display like/heart', 'mthemelocal'),
					'desc' => __('Displays like/heart', 'mthemelocal'),
					'options' => array(
						'no' => __('No','mthemelocal'),
						'yes' => __('Yes','mthemelocal')
					)
				),
				'linktype' => array(
					'type' => 'select',
					'label' => __('Link Type', 'mthemelocal'),
					'desc' => __('Link Type. Linked method uses image link field in Media manager image section.', 'mthemelocal'),
					'options' => array(
						'lightbox' => __('Lightbox','mthemelocal'),
						'download' => __('Downloadable','mthemelocal'),
						'url' => __('Link using Image link data','mthemelocal'),
						'purchase' => __('Link using image data purchase link','mthemelocal')
					)
				),
				'boxtitle' => array(
					'type' => 'select',
					'label' => __('Box Title', 'mthemelocal'),
					'desc' => __('Display title on hover ( in Wall Style )', 'mthemelocal'),
					'options' => array(
						'false' => __('No','mthemelocal'),
						'true' => __('Yes','mthemelocal')
					)
				),
				'title' => array(
					'type' => 'select',
					'label' => __('Dispay image title', 'mthemelocal'),
					'desc' => __('Display image title ( Classic and Default Style )', 'mthemelocal'),
					'options' => array(
						'true' => __('Yes','mthemelocal'),
						'false' => __('No','mthemelocal')
					)
				),
				'description' => array(
					'type' => 'select',
					'label' => __('Display image description', 'mthemelocal'),
					'desc' => __('Display image description ( Classic and Default Style )', 'mthemelocal'),
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
			'shortcode' => '[thumbnails effect="{{effect}}" style="{{style}}" linktype="{{linktype}}" like="{{like}}" filterall="{{filterall}}" gutter="{{gutter}}" filter="{{filter}}" boxtitle="{{boxtitle}}" columns="{{columns}}" format="{{format}}" title="{{title}}" pb_image_ids="{{pb_image_ids}}" description="{{description}}"]',
			'popup_title' => __('Insert Thumbnails Shortcode', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['thumbnails'];

		parent::__construct('em_thumbnails', $block_options);
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