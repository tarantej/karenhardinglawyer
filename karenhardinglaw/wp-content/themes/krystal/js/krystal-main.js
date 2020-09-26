
  (function ($) {

    $(window).load(function () {
        $("#pre-loader").delay(500).fadeOut();
        $(".loader-wrapper").delay(1000).fadeOut("slow");
    });

    $('.navbar-toggle').on('click', function () {
        if(!$('header').hasClass('fixed')) {           
          /* navbar toggle click */ 
        }              
    });   


    $(document).ready(function () { 
        
        $('.contact-section form input[type="submit"]').wrap('<div class="contact-button"></div>'); 

        $('ul.nav a').each(function() {
            $(this).attr('data-scroll', '');
        });       

        /*-- resize parallax size --*/
        $('ul#filter li a').click(function(e) {              
           $(window).trigger('resize.px.parallax');
        });       

        /*-- Magnific Popup --*/
        $('.image-popup-link').magnificPopup({
            type: 'image',
            closeOnBgClick: true,
            fixedContentPos: false,              
        }); 

        $('.video-popup-link').magnificPopup({
            type: 'iframe',
            closeOnBgClick: true,
            fixedContentPos: false,              
        });

        /*-- Button Up --*/
        var btnUp = $('<div/>', { 'class': 'btntoTop' });
        btnUp.appendTo('body');
        $(document).on('click', '.btntoTop', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 700);
        });

        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 200)
                $('.btntoTop').addClass('active');
            else
                $('.btntoTop').removeClass('active');
        });

        /*-- Menu toggle -- */
        var menubutton = $('.navbar-toggle i.fas');
        var menudiag = $('.res-menu .navbar-collapse');
        menubutton.on('click', function(){
            if (menubutton.hasClass('fa-bars') && !menudiag.hasClass('in')) {
                menubutton.removeClass('fa-bars').addClass('fa-times');
            }
            else{
                menubutton.removeClass('fa-times').addClass('fa-bars');
            }
        });

    });    

})(this.jQuery);