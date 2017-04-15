$(function(){
  //tr要素をクリックでイベント発火
  $('.user-list tr').click(function() {
    //td要素からチェックボックスを探す
    var $c = $(this).children('td').children('div').children('input[type=checkbox]');
    // console.log($c);
    if($c.prop('checked')) {
       $c.prop('checked', '');
     } else {
       $c.prop('checked', 'checked');
     }
  });

  $('.js-comstatus').change(function() {
    var obj;
    // console.log($(this).val());
    obj = $(this).parents('.comment').children('div').children('.comment-title');
    if ($(this).val() == '1') {
      $(obj).addClass("approval-bg-color");
      $(obj).removeClass("denial-bg-color");
      $(obj).removeClass("unapproval-bg-color")
      $(obj).children('.js-comment-label').text('コメント（承認）')
    } else if ($(this).val() == '2') {
      $(obj).removeClass("approval-bg-color");
      $(obj).addClass("denial-bg-color");
      $(obj).removeClass("unapproval-bg-color")
      $(obj).children('.js-comment-label').text('コメント（否認）')
    } else {
      $(obj).removeClass("approval-bg-color");
      $(obj).removeClass("denial-bg-color");
      $(obj).addClass("unapproval-bg-color")
      $(obj).children('.js-comment-label').text('コメント（未承認）')
    }
  });

  // $('.fileinput').on("change", function() {
  //   var file = this.files[0];
  //   if(file != null) {
  //     $files = $('.file-area').children('ul');
  //     console.log($files);
  //     var tag = '<li>' +
  //         '<a href="" class="icon-pdf-del" />' +
  //         '<p class="pdf-file bvc">' + file.name + '</span></p>'
  //         '</li>';
  //     $files.append(tag);
  //     console.log(file.name); // ファイル名をログに出力する
  //   }
  // });

  $(".fileinput").change(fileInputChange);
  function fileInputChange(){
    // console.log($(this));

    if($(".fileinput").last().val() != ""){
      // console.log($(".fileinput").length);
      $files = $('.file-area').children('ul');
      console.log($files);
      var name = $(".fileinput").last().val().replace('C:\\fakepath\\', '');
      // console.log($files);
      var filename = '<li>' +
          '<a href="" class="icon-pdf-del" />' +
          '<p class="pdf-file bvc">' + name + '</span></p>'
          '</li>';
      $files.append(filename);

      $.each($(".fileinput"), function(index,val) {
        // console.log($(val).parent().parent());
        var $obj = $(val).parent().parent();
        $obj.addClass("none");
        // $(val).addClass('none');
      });
      // $(".file-select-group").addClass("none");
      var count = $(".fileinput").length + 1;
      var tag = '<div class="file-select-group">' +
          '<label for="file_select' + count + '" class="file-select bvc">' +
          'ファイルを選択してください' +
          '<input type="file" id="file_select' + count + '" class="fileinput" accept="application/pdf">' +
          '</label>' +
          '<label for="file_select' + count + '" class="icon-clip"></label>';
      $(".file-select-area").append(tag).bind('change', fileInputChange);
      // $(".file-select-area").append('ssss').bind('change', fileInputChange);
    }
  }

});

