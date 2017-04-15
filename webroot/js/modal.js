$(function(){
  $('.modal-button').click(function() {
    console.log(123);
    var target = $(this).data('target');
    $('html').addClass('is-clipped');
    $(target).addClass('is-active');
  });

  $('.modal-background, .modal-close').click(function() {
    $('html').removeClass('is-clipped');
    $(this).parent().removeClass('is-active');
  });

  // $('.modal-card-head .delete, .modal-card-foot .button').click(function() {
  //   $('html').removeClass('is-clipped');
  //   $('#modal-ter').removeClass('is-active');
  // });

  $('.modal-footer .button').click(function() {
    $('html').removeClass('is-clipped');
    $('#modal-ter').removeClass('is-active');
  });
});

