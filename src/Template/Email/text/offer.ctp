

以下の方からオファーの申し込みがございました。
代表者の方は3日以内にメールボックス画面からオファーへの返答をして下さい。

https://www.engol.jp/member/

---------------------------
お申込みのお相手
---------------------------
■ニックネーム：<?=$User->nickname?>

■性別：<?=$User->sex_name?>


---------------------------
オファー内容
---------------------------
■希望日付1：<?php if($Offer->date1)echo $Offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付2：<?php if($Offer->date2)echo $Offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付3：<?php if($Offer->date3)echo $Offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

<?php if($Offer->course_kind == 1) {?>
■希望プレイ場所：<?=$Offer->course_prefecture_name?> <?=$Offer->course_name?>

<?php } else {?>
■希望プレイ場所：<?=$Offer->training_prefecture->name?> <?=$Offer->training_name?>

<?php }?>

※本メールにお心当たりがない場合には以下にお問い合わせ下さい
　EMail: info@engol.jp

---------------------------------------------------------------
エンゴル運営事務局
Web: https://www.engol.jp/
EMail: info@engol.jp
---------------------------------------------------------------
