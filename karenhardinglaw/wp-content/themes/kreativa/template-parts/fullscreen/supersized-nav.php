<?php
if ( ! kreativa_get_option_data('hcontrolbar_disable') ) {
?>
	<div class="slideshow-controls-wrap">
		<div id="controls-wrapper" class="load-item slideshow-control-item">
			<div id="controls">
				<!--Navigation-->
				<?php
				if ( ! kreativa_get_option_data('hplaybutton_disable') ) { ?>
					<a id="play-button" class="super-nav-item"><i id="pauseplay" class="ion-ios-pause"></i></a>
				<?php
				}
				?>
				<!--Arrow Navigation-->
				<?php if ( ! kreativa_get_option_data('hnavigation_disable') ) { ?>
					<a id="prevslide" class="prevnext-nav load-item super-nav-item"><i class="feather-icon-arrow-left"></i></a>
					<a id="nextslide" class="prevnext-nav load-item super-nav-item"><i class="feather-icon-arrow-right"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}
?>
<!--Control Bar-->
<!--Time Bar-->
<?php
	if ( ! kreativa_get_option_data('hprogressbar_disable') ) {
?>
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>
<?php
	}
?>