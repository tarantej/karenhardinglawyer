/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/
Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/
(function( $ ){
	var $window = $(window);
    var windowHeight = $window.height();

	$window.on('resize', function () {
        windowHeight = $window.height();
	});

    var uniqNum = 123;

    // init parallax
    var parallax = function($this, xpos, speedFactor, outerHeight) {

        the_block = $this;

        uniqNum += 68;
        var instanceName = 'jqueryparallax' + uniqNum;
        $this.data('jquery-parallax-instance', instanceName);

        // function to be called whenever the window is scrolled or resized
        function update(){
            //get the starting position of each element to have parallax applied to it
            var firstTop = $this.offset().top;
            var pos = $window.scrollTop();              
            var top = $this.offset().top;
            var height = outerHeight ? $this.outerHeight(true) : $this.height();

            realHeight = $this.outerHeight();

            // Check if totally above or totally below viewport
            if (top + height < pos || top > pos + windowHeight) {
                return;
            }
            if ( realHeight > windowHeight ) {
                return;
            }
            var speedFactor = 0.05;
            $this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
        }       

        $window.on('scroll.' + instanceName + ' resize.' + instanceName + ' load.' + instanceName + '', function() {
            window.requestAnimationFrame(update);
        });
        update();
    };

    // destroy parallax
    var destroy = function($this) {
        var instance = $this.data('jquery-parallax-instance');
        if(instance) {
            $window.off('.' + instance);
            $this.removeData('jquery-parallax-instance')
            $this.css('backgroundPosition', '');
        }
    };

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
        $(this).each(function() {
            if(xpos == 'destroy') {
                destroy($(this));
            } else {
                parallax(
                    $(this),
                    typeof xpos !== 'undefined' ? xpos : '50%',
                    typeof speedFactor !== 'undefined' ? speedFactor : 0.1,
                    typeof outerHeight !== 'undefined' ? outerHeight : true
                );
            }
        })
	};
})(jQuery);
