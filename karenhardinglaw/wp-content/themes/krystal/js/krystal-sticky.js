
  (function ($) {
    $(document).ready(function () { 
        
        /*-- Window scroll function --*/
        $(window).on('scroll', function () {
          
            /* sticky header */        
            var sticky = $('header'),
            scroll = $(window).scrollTop();            

            if (scroll >= 190) {
                sticky.addClass('fixed');
                $('#logo-alt').css({'display': 'block'});
                $('a.custom-logo-link').css({'display': 'none'});                
                $(window).trigger('resize.px.parallax');                
                
            }
            else {               
                sticky.removeClass('fixed');
                $('#logo-alt').css({'display': 'none'});
                $('a.custom-logo-link').css({'display': 'block'});
                $(window).trigger('resize.px.parallax');                
                
            }
          
        });
   });    

})(this.jQuery);