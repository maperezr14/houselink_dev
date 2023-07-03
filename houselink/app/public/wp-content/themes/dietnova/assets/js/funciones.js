jQuery(document).ready(function () {
  jQuery('.ir-formulario').click(function(){
      jQuery('html,body').animate({
          scrollTop: jQuery("#contacto").offset().top - 100},
      'slow');
  });
  
  //Galeria
  jQuery('.materialboxed').materialbox();

  //TyC Forms
  jQuery('#showPP').on('click', function (e) {
    jQuery('#pp').fadeIn(300)
  });

  jQuery('.close-box').on('click', function (e) {
    jQuery('.lightbox-tyc').fadeOut(300)
  });

  //Menú Mobile
  jQuery('.sidenav-trigger').on('click', function (e) {
      jQuery(this).toggleClass('open');
      jQuery('#menu-mobile').slideToggle();
  });
  jQuery('#menu-mobile li.menu-item.menu-item-has-children').on('click', function (e) {
      jQuery(this).find('.dropdown-content').slideToggle(300);
  });


  jQuerysldTresServ = jQuery('#services .slider-servicios');
  jQuerysldTresServ.not('.slick-initialized').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    arrows: false,
    centerMode: true,
    dots: false,
    autoPlay: false,
    speed: 500,
    autoplaySpeed: 5000,
    responsive: [{
      breakpoint: 768,
      settings: {
        arrows: true,
        prevArrow: '<div class="slick-prev"><img src="'+URLTHEME+'/assets/img/arrow-prev.png" alt="Previo" /></div>',
        nextArrow: '<div class="slick-next"><img src="'+URLTHEME+'/assets/img/arrow-next.png" alt="Siguiente" /></div>',
        dots: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        prevArrow: '<div class="slick-prev"><img src="'+URLTHEME+'/assets/img/arrow-prev.png" alt="Previo" /></div>',
        nextArrow: '<div class="slick-next"><img src="'+URLTHEME+'/assets/img/arrow-next.png" alt="Siguiente" /></div>',
        dots: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }]
  });

  jQuerysldTresPlan = jQuery('#tarifas .slider-planes');
  jQuerysldTresPlan.not('.slick-initialized').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    arrows: false,
    centerMode: true,
    dots: false,
    autoPlay: false,
    speed: 500,
    autoplaySpeed: 5000,
    responsive: [{
      breakpoint: 768,
      settings: {
        arrows: true,
        prevArrow: '<div class="slick-prev"><img src="'+URLTHEME+'/assets/img/arrow-prev.png" alt="Previo" /></div>',
        nextArrow: '<div class="slick-next"><img src="'+URLTHEME+'/assets/img/arrow-next.png" alt="Siguiente" /></div>',
        dots: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        prevArrow: '<div class="slick-prev"><img src="'+URLTHEME+'/assets/img/arrow-prev.png" alt="Previo" /></div>',
        nextArrow: '<div class="slick-next"><img src="'+URLTHEME+'/assets/img/arrow-next.png" alt="Siguiente" /></div>',
        dots: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }]
  });
 
  // jQuery(window).on("resize", function (e) {
  //     checkScreenSize();
  // });

  // checkScreenSize();

  // function checkScreenSize(){
  //     var newWindowWidth = jQuery(window).width();
  //     if (newWindowWidth < 481) {

  //     }
  //     else
  //     {

  //     }
  // }


  //Select Multiple
  jQuery('select').formSelect();


  var page = 2;

  jQuery(document).on('click', '.mas-noticias #loadMore', function(e) {
    e.preventDefault();
    var data = {
        'action': 'vermas_blog',
        'page': page,
        'security': ajaxhouselink.seguridad,
        'actual':post_actual,
    };

    jQuery.post(ajaxhouselink.ajaxurl, data, function(response) {
        if(response != '') {
          page++;
          jQuery('html,body').stop().animate({
            scrollTop: jQuery('#loadMore').offset().top
          }, 1000, function(){
            
          });

          setTimeout(function(){ 
            jQuery('.otras-noticias').append(response); 
          }, 1100);

        } else {
            jQuery('#loadMore').hide();
        }
    });
  });

  jQuery('.info-contenido .share a, .share-news a').click(function(e) {
      e.preventDefault();
      var url = jQuery(this).attr("href");
      var left = Number((screen.width / 2) - (700 / 2));
      var top = Number((screen.height / 2) - (500 / 2));
      window.open(url, "", 'height=500,width=500,top=' + top + ',left=' + left);

  });



  jQuery(window).scroll(function(){
    if( jQuery(this).scrollTop() > 0 ){
      jQuery('header').addClass('header-fixed');
    } else {
      jQuery('header').removeClass('header-fixed');
    }
  });

});

 
jQuery("#busqueda").focusout(function(){

  jQuery(".resultado.active").css("display", "none");
});

jQuery("#busqueda").focusin(function(){

  jQuery(".resultado.active").css("display", "block");
});


jQuery(".resultado").hover(
  function(){

      jQuery(".resultado.active").css("display", "block");
      jQuery("#busqueda").off("focusout");
    
  },
  function(){

      jQuery(".resultado.active").css("display", "none");
      jQuery("#busqueda").on("focusout",function(){
        jQuery(".resultado.active").css("display", "none");
      });
  }
)
