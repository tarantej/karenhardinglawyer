<?php
$featured_page=kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
$sound_found=false;
$mp3_ext='';
$mp3_sep='';
$m4a_ext='';
$m4a_sep='';
$oga_ext='';
if (isset($custom[ "pagemeta_slideshow_mp3"][0])) $mp3_file=$custom[ "pagemeta_slideshow_mp3"][0];
if (isset($custom[ "pagemeta_slideshow_m4a"][0])) $m4a_file=$custom[ "pagemeta_slideshow_m4a"][0];
if (isset($custom[ "pagemeta_slideshow_oga"][0])) $oga_file=$custom[ "pagemeta_slideshow_oga"][0];

if ( isset($mp3_file) && $mp3_file<>'' ) { $sound_found=true; $mp3_ext ="mp3"; if ($m4a_file || $oga_file){ $mp3_sep=",";} }
if ( isset($m4a_file)  && $m4a_file<>'' ) { $sound_found=true; $m4a_ext ="m4a"; if ($oga_file){ $m4a_sep=",";} }
if ( isset($oga_file)  && $oga_file<>'' ) { $sound_found=true; $oga_ext ="oga";  }

if ($sound_found) {
	$files_used=$mp3_ext.$mp3_sep.$m4a_ext.$m4a_sep.$oga_ext;
}

if ( $sound_found ) {
	$loop_sound = "false";
	if ( kreativa_get_option_data('audio_loop') ) {
		$loop_sound = "true";
	}
	$volume_level = kreativa_get_option_data('audio_volume')/100;
?>
<div class="fullscreenslideshow-audio">
<div id="jquery_jplayer_<?php the_ID(); ?>" class="fullscreenslideshow-audio-player jp-jplayer" data-loop="<?php echo esc_js( $loop_sound ); ?>" data-volume="<?php echo esc_js( $volume_level ); ?>" data-autoplay="false" data-id="<?php the_ID(); ?>" data-audiofiles="<?php echo esc_attr($files_used); ?>" data-oga="<?php echo esc_url($oga_file); ?>" data-m4a="<?php echo esc_url($m4a_file); ?>" data-mp3="<?php echo esc_url($mp3_file); ?>" data-swfpath="<?php echo esc_url( get_stylesheet_directory_uri() . '/js/html5player/' ); ?>"></div>
<div class="jp-audio">
	<div class="jp-type-single">
		<div id="jp_interface_<?php esc_attr(the_ID()); ?>" class="jp-interface">
			<ul class="jp-controls">
				<li><a href="#" class="jp-pause" tabindex="1"><div class="equalizer">
   <div class="equalizer-bar"></div>
   <div class="equalizer-bar"></div>
   <div class="equalizer-bar"></div>
</div></a></li>
				<li><a href="#" class="jp-play" tabindex="1"><div class="equalizer">
   <div class="equalizer-bar"></div>
   <div class="equalizer-bar"></div>
   <div class="equalizer-bar"></div>
</div></a></li>
				<li>
			</ul>
		</div>
	</div>
</div>
</div>
<?php
?>
<?php
}
?>