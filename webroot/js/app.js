$(function() {
  var pagetop = $('.pagetop');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      pagetop.fadeIn();
    } else {
      pagetop.fadeOut();
    }
  });
  pagetop.click(function () {
    $('body, html').animate({ scrollTop: 0 }, 500);
      return false;
  });

  $('.slick-slider').slick({
    dots: true,
    slidesToShow: 4, //スライドが見える数
    centerMode: true,
    slidesToScroll: 1, //スライドがスクロールする数
    // infinite: true, //無限スクロール
    draggable: true, //マウスドラッグでのスクロール
    swipeToSlide: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          centerMode: true,
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          centerMode: true,
          slidesToShow: 2
        }
      }
    ]
  });
  // $('.slick-slider').slick({
  //   centerMode: true,
  //   slidesToShow: 3,
  // });

  $('.conv-button').hover (
    function () {
      // $(this).children(".img1").before('<img src="./img/btn_conversion_hover.png" alt="" class="img2" >').fadeOut("slow");
      $(this).children('img').attr("src","./img/btn_conversion_hover.png");
    },
    function () {
      $(this).children('img').attr("src","./img/btn_conversion.png");
      // $(this).children(".img1").fadeIn("slow",function(){
      //   $('.conv-button').children(".img2").remove();
      // });
    }
  );
});