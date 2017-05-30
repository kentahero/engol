
この度はエンゴルにお申込み頂きまして誠にありがとうございます。
以下の通りオファーを申し込みましたのでご確認下さい。

<?php if (!$member) {?>
---------------------------
ご登録内容
---------------------------
■メールアドレス：<?=$User->email?>

■お名前：<?=$User->first_name?> <?=$User->last_name?>

■お名前カナ：<?=$User->first_kana?> <?=$User->last_kana?>

■ニックネーム：<?=$User->nickname?>

■性別：<?=$User->sex_name?>

■生年月日：<?=$User->birth->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■郵便番号：<?=$User->postal?>

■都道府県：<?=$User->prefecture_name?>

■市区町村：<?=$User->city_name?>

■町名番地：<?=$User->address1?>

■建物名・部屋番号：<?=$User->address2?>

■電話番号：<?=$User->tel?>
<?php } ?>

---------------------------
オファー内容
---------------------------
■オファーのお相手：<?=$Group->users[0]->nickname?>

■希望日付1：<?php if($Offer->date1)echo $Offer->date1->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付2：<?php if($Offer->date2)echo $Offer->date2->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

■希望日付3：<?php if($Offer->date3)echo $Offer->date3->i18nFormat('YYYY年MM月dd日', 'Asia/Tokyo')?>

<?php if($Offer->course_kind == 1) {?>
■希望プレイ場所：<?=$Offer->course_prefecture_name?> <?=$Offer->course_name?>

<?php } else {?>
■希望プレイ場所：<?=$Offer->training_prefecture->name?> <?=$Offer->training_name?>

<?php }?>


お相手よりオファーに対する返答があるまでお待ち下さい。
オファーが承諾されればマッチング成立となり料金のお支払手続きをお願いいたします。

※本メールにお心当たりがない場合には以下にお問い合わせ下さい
　EMail: info@engol.jp

---------------------------------------------------------------
エンゴル運営事務局
Web: https://www.engol.jp/
EMail: info@engol.jp
---------------------------------------------------------------
