
お支払いが完了しご成約が確定しました。
お相手の分もゴルフ場の予約をして下さい。
また、当日に指定されたゴルフ場または練習場にお越しください。

なお、どうしても都合がつかない場合には
当日の3日前であればキャンセルが可能です。
メールボックス画面からキャンセル操作をして下さい。

---------------------------
オファー内容
---------------------------
■決定日付：<?php echo $offer->play_date->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>


<?php if($offer->course_kind == 1) {?>
■プレイ場所：<?=$offer->course_prefecture->name?> <?=$offer->course_name?>

<?php } else {?>
■プレイ場所：<?=$offer->training_prefecture->name?> <?=$offer->training_name?>

<?php }?>

※本メールにお心当たりがない場合には以下にお問い合わせ下さい
　EMail: info@engol.jp

---------------------------------------------------------------
エンゴル運営事務局
Web: https://www.engol.jp/
EMail: info@engol.jp
---------------------------------------------------------------
