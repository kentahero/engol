
オファーが拒否されました
別のペアか別の日程、場所で再度オファーして下さい

---------------------------
お申込みのお相手
---------------------------
■ニックネーム：<?=$offer->receive_group->users[0]->nickname?>


---------------------------
オファー内容
---------------------------
■希望日付1：<?php if($offer->date1)echo $offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付2：<?php if($offer->date2)echo $offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付3：<?php if($offer->date3)echo $offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

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
