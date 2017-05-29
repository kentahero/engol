$(function(){

  //都道府県選択時のイベント
  $('#prefecture_cd').change(function() {
	//市区町村プルダウンの選択を初期化
	$('#city_cd option').remove();
	$('#city_cd optgroup').remove();
	$('#city_cd').append($('<option>').html("市区町村").val(""));

	//ajaxで市区町村リスト取得
	$.ajax({
		type: "POST",
		url: "/top/get_city_list",
		data: { is_json: 1,prefecture_cd: $('#prefecture_cd').val()}
	}).done(function( res ) {
		for(var i in res.cities){
			$option = $('<option>').val(i).text(res.cities[i]);
			//市区町村項目を追加
			$('#city_cd').append($option);
		}
	});
  });

  $('input[name="Offer[course_kind]"]:radio').change( function() {
	  var course_kind = $('input[name="Offer[course_kind]"]:checked').val();
	  if (course_kind == "1") {
		  $('#course_prefecture').show();
		  $('#course_name_tr').show();
		  $('#course_name_other').show();
		  $('#training_prefecture').hide();
		  $('#training_name').hide();
	  } else if(course_kind == "2") {
		  $('#course_prefecture').hide();
		  $('#course_name_tr').hide();
		  $('#course_name_other').hide();
		  $('#training_prefecture').show();
		  $('#training_name').show();
	  }
  });

  //ゴルフ場都道府県選択時のイベント
  $('#course_prefecture_cd').change(function() {
	  $('#course_id option').remove();
	  $('#course_id').append($('<option>').html("ゴルフ場選択").val(""));
	  //ajaxで市区町村リスト取得
	  getCourseList(1);
  });

  $('input[name="Offer[course_kind]"]:radio').change();

});

function getCourseList(page) {
	$.ajax({
        type: "POST",
		url: "https://app.rakuten.co.jp/services/api/Gora/GoraGolfCourseSearch/20131113",
		data: { format: 'json', formatVersion:2, applicationId: '1062787586708515126', page: page, areaCode: $('#course_prefecture_cd').val(), sort: '50on'}
	  }).done(function( res ) {
		var head = "";
		for(var i in res.Items){
		  $option = $('<option>').val(res.Items[i].golfCourseName).text(res.Items[i].golfCourseName);
		  $('#course_name').append($option);
　　    }
		if (res.page != res.pageCount) {
			getCourseList(res.page+1);
		}
	 });
}