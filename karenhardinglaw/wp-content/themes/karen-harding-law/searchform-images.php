<?php

$placeholder_text = kreativa_get_option_data('stockphoto_input_placeholder');
if ($placeholder_text=="") {
    $placeholder_text = 'Search images';
}
?>
<input type="text" value="" name="s" id="s" class="right" placeholder="<?php echo esc_attr($placeholder_text); ?>" />
<input class="button" type="hidden" name="photostock" value="1" />
<button class="ntips" id="searchbutton" type="submit"><i class="ion-ios-search"></i></button>