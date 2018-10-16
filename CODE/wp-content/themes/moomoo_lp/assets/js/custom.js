(function($){
  $('.moomoo-slide').slick({   
    infinite: true,
    speed: 300,
    slidesToShow: 6,
    slidesToScroll: 6,
    responsive: [
      {
        breakpoint: 993,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      }
      
    ]
  });
 
  var height_admin_bar = $('div#wpadminbar').height();
  if($('div#wpadminbar').length <1){
    height_admin_bar = 0;
  }    
   
  $(window).load(function(){
    $('body').removeAttr('id');
  })

})(jQuery);