<?php
/**
 * Stockphoto
 *
 */
class em_stockphoto extends AQ_Block {
	public function __construct() {
		$block_options = array(
			'pb_block_icon' => 'simpleicon-grid',
			'pb_block_icon_color' => '#77DD77',
			'name' => __('Stockphoto Grid','mthemelocal'),
			'size' => 'span12',
			'tab' => __('Media','mthemelocal'),
			'desc' => __('Generate a StockPhoto Grid','mthemelocal')
		);

		$mtheme_shortcodes['stockphoto'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Generate a StockPhoto grid', 'mthemelocal'),
			'params' => array(
		            'image' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Header background image URL', 'mthemelocal'),
		                'desc' => __('Header image. Add archive image for Stockphoto via Theme Options.', 'mthemelocal'),
		            ),
				    'text_intensity' => array(
				      'type' => 'select',
				      'label' => __('Text Intensity', 'mthemelocal'),
				      'desc' => __('Text Intensity for headings types', 'mthemelocal'),
				      'options' => array(
				        'default' => __('Default', 'mthemelocal'),
				        'dark' => __('Dark','mthemelocal'),
				        'bright' => __('Bright','mthemelocal')
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
					)
			),
			'shortcode' => '[display_stockphotos text_intensity="{{text_intensity}}" titlecolor="{{titlecolor}}" title="{{title}}" description="{{description}}" display_stocktags="{{display_stocktags}}" image="{{image}}" gutter="nospace" align="center" size="1"]',
			'popup_title' => __('Add StockPhoto', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['stockphoto'];

		parent::__construct('em_stockphoto', $block_options);
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