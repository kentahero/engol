$(function(){

  //都道府県選択時のイベント
  $('#prefecture_cd').change(function() {
	  getCityList('');
  });
  //コース選択時のイベント
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

  //住所検索ボタン押下時のイベント
  $('#search_postal').click(function(){
	 var zip = $('#postal').val();
	 if (zip == '') {
		 return;
	 }
	 $.ajax({
		 type : 'get',
	     url : 'https://maps.googleapis.com/maps/api/geocode/json',
	     crossDomain : true,
	     dataType : 'json',
	     data : {
	    	 address : zip,
	    	 language : 'ja',
	    	 sensor : false
	     },
		 success : function(resp){
			 if(resp.status == "OK"){
				 // APIのレスポンスから住所情報を取得
				 var obj = resp.results[0].address_components;
				 if (obj.length < 5) {
					 alert('正しい郵便番号を入力してください');
					 return false;
				 }
				 if (obj.length == 5) {
					 text_selector('#prefecture_cd',obj[3]['long_name']); // 都道府県
					 getCityList(obj[2]['long_name']);
				 } else if (obj.length == 6) {
					 text_selector('#prefecture_cd',obj[4]['long_name']); // 都道府県
					 getCityList(obj[3]['long_name'] + obj[2]['long_name']);
				 }
				 $('#address1').val(obj[1]['long_name']); // 番地
	        }else{
	        	alert('住所情報が取得できませんでした');
	        	return false;
	        }
	     }
	 });
  });

  $('input[name="Offer[course_kind]"]:radio').change();

});

function getCityList(selected_city) {
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
		if (selected_city != '') {
			text_selector('#city_cd',selected_city);
		}
	});
}

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