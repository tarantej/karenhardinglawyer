<?php
class mTheme_Instagram_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'mtheme_instagram_widget', 'description' => __( 'Instagram Embed Widget', 'mthemelocal') );
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('instagram_details',__('Kreativa Instagram', 'mthemelocal'), $widget_ops,$control_ops);
		
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Instagram', 'mthemelocal') : $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
		if ( $title) {
			echo $before_title . $title . $after_title;
		}
		
		$columns = 1;
		$token = kreativa_get_option_data('insta_token');
		if ( isSet($token) ) {
			if ( shortcode_exists('insta_carousel') ) {
				$insta_image_limit = kreativa_get_option_data('insta_image_limit');
				if ( !isSet($insta_image_limit) || $insta_image_limit==0 ) {
					$insta_image_limit = 6;
				}
				echo do_shortcode('[insta_carousel count="'.$insta_image_limit.'" columns="'.$columns.'" token="'.$token.'"]');
			}
		}

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		

		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
	?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("mTheme_Instagram_Widget");'));