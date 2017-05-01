$(function(){
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
});