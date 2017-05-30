
オファーが承諾されました。
メールボックスから承諾されたオファーを選択して利用料金のお支払いをお願いいたします。
お支払い完了後にご成約となります。

https://www.engol.jp/member/

---------------------------
オファー内容
---------------------------
■決定日付：<?php echo $offer->play_date->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>


<?php if($offer->course_kind == 1) {?>
■希望プレイ場所：<?=$offer->course_prefecture->name?> <?=$offer->course_name?>

<?php } else {?>
■希望プレイ場所：<?=$offer->training_prefecture->name?> <?=$offer->training_name?>

<?php }?>

※本メールにお心当たりがない場合には以下にお問い合わせ下さい
　EMail: info@engol.jp

---------------------------------------------------------------
エンゴル運営事務局
Web: https://www.engol.jp/
EMail: info@engol.jp
---------------------------------------------------------------
