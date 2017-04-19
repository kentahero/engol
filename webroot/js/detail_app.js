$(function() {
  var pagetop = $('.pagetop-detail');
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

  var reserve_btn = $('.reserve-btn');
  $(window).scroll(function () {
    var scrollHeight = $(document).height();
    var scrollPosition = $(window).height() + $(window).scrollTop();
    if (scrollHeight - scrollPosition < 1) { // 1メディクエリによる微調整で1pxは許容範囲
      reserve_btn.fadeOut();
    } else {
      reserve_btn.fadeIn();
    }
  });

  $('.slick-slider-detail').slick({
    dots: true,
    slidesToShow: 3, //スライドが見える数
    centerMode: true,
    slidesToScroll: 1, //スライドがスクロールする数
    // infinite: true, //無限スクロール
    draggable: true, //マウスドラッグでのスクロール
    swipeToSlide: true,
    initialSlide: -1,
    responsive: [
      // {
      //   breakpoint: 768,
      //   settings: {
      //     centerMode: true,
      //     slidesToShow: 3
      //   }
      // },
      {
        breakpoint: 480,
        settings: {
          centerMode: false,
          slidesToShow: 1
        }
      }
    ]
  });


});